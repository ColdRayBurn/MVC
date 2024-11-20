<?php

namespace Activitar;

use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\SystemException;

trait IblockHelper
{
    /**
     * Объект таблицы - ОРМ
     * @var object
     */
    private object $tableObj;
    private int $cacheTtl;


    public function initIblockHelper(object $tableObj): object
    {
        try {
            \Bitrix\Main\Loader::includeModule('iblock');
        } catch (\Bitrix\Main\LoaderException $loaderException) {
            throw new \Bitrix\Main\LoaderException($loaderException->getMessage());
        }

        $this->tableObj = $tableObj;
        $this->cacheTtl = self::getCacheTtlValue();

        return $this->tableObj;
    }


    public function getApiObj(): object
    {
        return $this->tableObj;
    }

    public function setApiObj(object $tableObject): void
    {
        $this->tableObj = $tableObject;
    }

    /**
     * маппинг полей ИБ
     * @return array
     */
    public function fieldsMap(): array
    {
        return $this->tableObj::getMap();
    }

    /**
     * @throws SystemException
     */
    private function extendEntityWithPathFields(object $query): object
    {
        $query->addField(
            $this->getSectionCodePathField()
        );

        $query->addField(
            $this->getDetailPageUrlField()
        );

        return $query;
    }

    /**
     * @throws SystemException
     */
    private function getSectionCodePathField(): ExpressionField
    {
        $levels = 5;
        $placeholders = [];
        for ($i = $levels; $i > 0; $i--) {
            $placeholders[] = str_repeat('PARENT_SECTION.', $i - 1) . 'CODE';
        }
        $placeholders[] = 'CODE';

        return new ExpressionField(
            'SECTION_CODE_PATH',
            'CONCAT(' . implode(', "/", ', array_fill(0, count($placeholders), 'COALESCE(%s, "")')) . ')',
            $placeholders
        );
    }

    /**
     * @throws SystemException
     */
    private function getDetailPageUrlField(): ExpressionField
    {
        $replacements = [
            '#ID#' => '%s',
            '#ELEMENT_CODE#' => '%s',
            '#SECTION_CODE_PATH#' => '%s',
            '#SECTION_CODE#' => '%s',
            '#SITE_DIR#' => ''
        ];

        $replaceQuery = '';
        foreach ($replacements as $placeholder => $replacement) {
            $replaceQuery .= "REPLACE(%s, '{$placeholder}', {$replacement}), ";
        }

        return new ExpressionField(
            'DETAIL_PAGE_URL',
            rtrim($replaceQuery, ', '),
            ['IBLOCK.DETAIL_PAGE_URL', 'ID', 'CODE', 'SECTION_CODE_PATH', 'IBLOCK_SECTION.CODE']
        );
    }


    /**
     * МЕтод получения данных из ИБ fetchAll не для большого количества данных если
     * @param array $select
     * @param array $filter
     * @param array $order
     * @param int|null $limit
     * @param int|null $offset
     * @param array $runtime
     * @param bool $cache
     * @param array $cacheSettings
     * @param array $multiplePropsIdArray
     * @return array|null
     * @throws \Exception
     */
    public function getDataFormTable(
        array $select,
        array $filter = [],
        array $order = [],
        int   $limit = null,
        int   $offset = null,
        bool  $cache = false,
        array $multiplePropsIdArray = [],
    ): ?array
    {
        if (empty($this->tableObj))
            return null;

        if (empty($select))
            return null;

        $resultArray = [];
        $descriptionValuesArray = $this->getDescriptionValuesArray();
        $elementEntity = $this->tableObj::getEntity();
        $this->extendEntityWithPathFields($elementEntity);

        $query = new Query($elementEntity);

        $query->setSelect($select)
            ->setFilter($filter)
            ->setOrder($order);

        if (!is_null($offset))
            $query->setOffset($offset);
        if (!is_null($limit))
            $query->setLimit($limit);
        if ($cache) {
            $query->setCacheTtl($this->cacheTtl);
            $query->cacheJoins('Y');
        }

        $queryCollection = $query->fetchCollection();

        if (empty($queryCollection))
            return [];

        foreach ($queryCollection as $key => $item) {

            foreach ($select as $itemSelect) {
                if (array_key_exists($itemSelect, $multiplePropsIdArray)) {

                    $this->getMultipleProperties(
                        item: $item,
                        itemSelect: $itemSelect,
                        multiplePropsIdArray: $multiplePropsIdArray,
                        key: $key,
                        resultArray: $resultArray
                    );

                    continue;
                }

                $resultArray[$key][$itemSelect] = $item->get($itemSelect);

                if (is_object($resultArray[$key][$itemSelect])) {
                    if ($resultArray[$key][$itemSelect] instanceof \Bitrix\Main\Type\DateTime) {
                        $formattedDate = $resultArray[$key][$itemSelect]->format($this->getDataFormat());
                        $resultArray[$key][$itemSelect] = $formattedDate;
                        continue;
                    }

                    $resultArray[$key][$itemSelect] = $resultArray[$key][$itemSelect]->getValue();

                    if (in_array($itemSelect, $descriptionValuesArray)) {
                        $resultArray[$key][$itemSelect . '_DESCRIPTION'] = $resultArray[$key][$itemSelect]->getDescription();
                    }
                }
            }

        }

        self::getFiles(elements: $resultArray);

        return array_values($resultArray);
    }

    private function getMultipleProperties(
        object $item,
        string $itemSelect,
        array  $multiplePropsIdArray,
        int    $key,
        array  &$resultArray
    ): void
    {

        foreach ($item->get($itemSelect)->getAll() as $value) {


            foreach ($multiplePropsIdArray[$itemSelect] as $multipleItem) {
                $itemArray = explode('.', $multipleItem);
                $paramsArray[] = $itemArray[1];
            }

            if (in_array('VALUE', $paramsArray))
                $resultArray[$key][$itemSelect . '_VALUE'][] = $value->getValue();

            if (in_array('DESCRIPTION', $paramsArray))
                $resultArray[$key][$itemSelect . '_DESCRIPTION'][] = $value->getDescription();

        }

    }


    /**
     * @param string $propCode
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Exception
     */
    public function getEnumProperty(array $propCode): array
    {
        if (empty($propCode)) {
            return [];
        }

        $propCode = array_filter($propCode, static function ($code) {
            return is_string($code) && !empty($code);
        });

        if (empty($propCode)) {
            return [];
        }

        $result = [];

        try {
            $query = new \Bitrix\Main\Entity\Query(\Bitrix\Iblock\PropertyEnumerationTable::getEntity());
            $query->setSelect(['ID', 'VALUE', 'XML_ID', 'CODE' => 'PROPERTY.CODE', 'SORT']);
            $query->setFilter(['=PROPERTY.CODE' => $propCode]);
            $query->setCacheTtl($this->cacheTtl);

            $propertyValues = $query->fetchAll();

            foreach ($propertyValues as $value) {
                $result[$value['CODE']][$value['ID']] = $value;
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $result;
    }

    public static function fillEnumProperties(array &$data, $enums): void
    {
        if (empty($data) || empty($enums)) {
            return;
        }

        foreach ($data as $key => $item) {
            if (!is_array($item)) {
                continue;
            }

            foreach ($item as $keyProp => $prop) {
                if (is_array($prop)) {
                    foreach ($prop as $keyItem => $propItem) {
                        foreach ($enums as $enumKey => $enum) {
                            if (!is_array($enum) || !isset($enum[$propItem]['VALUE'])) {
                                continue;
                            }

                            if ($keyProp == $enumKey . '_VALUE') {
                                $data[$key][$keyProp][$keyItem] = $enum[$propItem]['VALUE'];
                            }
                        }
                    }
                } else {
                    foreach ($enums as $enumKey => $enum) {
                        if (!is_array($enum) || !isset($enum[$prop]['VALUE'])) {
                            continue;
                        }

                        if ($keyProp == $enumKey) {
                            $data[$key][$keyProp] = $enum[$prop]['VALUE'];
                        }
                    }
                }
            }
        }
    }


    /**
     * @param array $element
     * @return void
     * @throws \Exception
     */

    public static function getFiles(array &$elements): void
    {
        if (empty($elements)) {
            return;
        }

        $filesMainDir = defined('FILES_MAIN_DIR') ? FILES_MAIN_DIR : '/upload/';
        $fileFields = self::getFileFields();

        if (empty($fileFields)) {
            return;
        }

        $arrayFiles = [];
        foreach ($elements as $element) {
            if (!is_array($element)) {
                continue;
            }

            foreach ($fileFields as $field) {
                if (!empty($element[$field])) {
                    if (is_array($element[$field])) {
                        array_push($arrayFiles, ...array_values($element[$field]));
                    } else {
                        $arrayFiles[] = $element[$field];
                    }
                }
            }
        }

        $arrayFiles = array_unique(array_filter($arrayFiles, 'is_numeric'));

        if (empty($arrayFiles)) {
            return;
        }

        $filesData = [];
        try {
            $entityFilesTable = \Bitrix\Main\FileTable::getEntity();
            $query = new Query($entityFilesTable);

            $filesCollection = $query
                ->setSelect(['ID', 'SUBDIR', 'FILE_NAME'])
                ->setFilter(['ID' => $arrayFiles])
                ->setCacheTtl(self::getCacheTtlValue())
                ->exec();

            while ($file = $filesCollection->fetch()) {
                if (!empty($file['ID']) && !empty($file['SUBDIR']) && !empty($file['FILE_NAME'])) {
                    $filesData[$file['ID']] = $file;
                }
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        foreach ($elements as &$element) {
            if (!is_array($element)) {
                continue;
            }

            foreach ($fileFields as $field) {
                if (!empty($element[$field])) {
                    if (is_array($element[$field])) {
                        foreach ($element[$field] as $subKey => $fileId) {
                            $element[$field][$subKey] = self::getCustomFilePath((int)$fileId, $filesData, $filesMainDir);
                        }
                    } else {
                        $fileId = (int)$element[$field];
                        $element[$field] = self::getCustomFilePath($fileId, $filesData, $filesMainDir);
                    }
                }
            }
        }
    }

    private static function getFileFields(): array
    {
        return [
            'PREVIEW_PICTURE',
            'DETAIL_PICTURE',
            'PICTURE',
            'MULTUPLE_FILE_VALUE',
            'FILE'
        ];
    }

    protected static function getCustomFilePath(int $fileId, array $filesData, string $filesMainDir): string
    {
        if (!isset($filesData[$fileId])) {
            return '';
        }

        $file = $filesData[$fileId];
        if (empty($file['SUBDIR']) || empty($file['FILE_NAME'])) {
            return '';
        }

        return $filesMainDir . $file['SUBDIR'] . '/' . $file['FILE_NAME'];
    }

    private static function getCacheTtlValue(): int
    {
        return defined('CACHE_TTL') ? CACHE_TTL : 3600;
    }

    private function getDataFormat(): string
    {
        return 'Y-m-d H:i:s';
    }

    public function getCountTotal(Query $query): null|string
    {
        return $query->queryCountTotal();
    }

    private function getDescriptionValuesArray(): array
    {
        return ['DIRECTOR'];
    }

}