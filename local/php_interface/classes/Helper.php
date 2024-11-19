<?php

namespace Activitar;


use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Loader;

class Helper
{


    public static function getBuildingType(int $sectionId): string
    {
        $options = OptionsData::getInstance();

        if ($options->jKSectionId === $sectionId
            || $options->jKSectionOldId === $sectionId
            || $options->jKSectionNewId === $sectionId
        ) {
            $buildingType = 'jk';
        } elseif ($options->KpSectionId === $sectionId) {
            $buildingType = 'kp';
        } else {
            $buildingType = '';
        }

        return $buildingType;
    }


    public static function getCleanUrl(): string
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        $uri = new \Bitrix\Main\Web\Uri($request->getRequestUri());
        return strtok($uri->getUri(), '?');
    }
    public static function parseUrlForCatalogFilters($url): array
    {
        $url = rtrim($url, '/');
        $pattern = '/catalog-object-(.*)/';
        if (preg_match($pattern, $url, $matches)) {
            $params_string = $matches[1];
            $params_array = explode('-', $params_string);
            $params = [];

            for ($i = 0; $i < count($params_array); $i += 2) {
                $key = $params_array[$i];
                $value = $params_array[$i + 1];
                if (str_contains($value, '_')){
                    $value = explode('_',$value);
                    $params[$key] = $value;
                }else{
                    $params[$key] = $value;
                }

            }

            return $params;
        } else {
            return [];
        }
    }

    public static function getJsonFile(string $path, array &$fileVariable) : void
    {
        $jsonString = file_get_contents($path);
        $data = json_decode($jsonString, true) ?? [];
        $fileVariable = $data;
    }
    public static function transliterate(string $text): string
    {
        $translit = array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ъ' => '-',
            'ы' => 'y',
            'ь' => '-',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            ' ' => '-',
            '.' => '-'
        );

        $text = mb_strtolower(preg_replace('/[^\w\d]/u', '-', $text));
        $text = strtr($text, $translit);
        $text = preg_replace('/-+/', '-', $text);

        return trim($text, '-');
    }

    /**
     * Выводим лог в консоль бразуера
     * @param mixed $data
     * @param bool $quotes
     * @return void
     */
    public static function log_to_console(mixed $data)
    {
        global $USER;

        if ($USER->IsAdmin()) {
            if (!is_array($data)) {
                $data = [$data];
            }

            $output = json_encode($data);
            echo "<script>console.log({$output} );</script>";
        }
    }

    public static function formatPrice(
        string $value,
        string $currency = 'RUB',
        bool $buildings = false,
        $byUnit = false,
        string $unitType = ''
    ) {
        if ($value > 0) {
            $value = number_format($value, 0, ',', ' ');
            $value = str_replace(',00', '', $value);
            if ($byUnit) {
                $value = $value . ' ' . $currency . ($unitType ? '/'.$unitType : '');
            } else {
                $value = $buildings ? 'От ' . $value . ' ' . $currency : $value . ' ' . $currency;
            }
        } else {
            $value = 'Цена по запросу';
        }

        return $value;
    }

    public static function truncateString(string $text, int $maxLength = 20): string
    {
        if (mb_strlen($text) > $maxLength) {
            return mb_substr($text, 0, $maxLength - 3) . '...';
        }
        return $text;
    }

    public static function getSectionIdByCode(int $iblockId, string $sectionCode): ?int
    {
        if (!Loader::includeModule('iblock')) {
            return null;
        }
        $sectionId = null;
        $result = SectionTable::getList([
            'select' => ['ID'],
            'filter' => [
                '=IBLOCK_ID' => $iblockId,
                '=CODE' => $sectionCode,
            ],
        ]);

        if ($section = $result->fetch()) {
            $sectionId = $section['ID'];
        }

        return $sectionId;
    }

    public static function getSectionCodeById(int $iblockId, string $sectionId): ?string
    {
        if (!Loader::includeModule('iblock')) {
            return null;
        }
        $sectionCode = null;
        $result = SectionTable::getList([
            'select' => ['ID', 'CODE'],
            'filter' => [
                '=IBLOCK_ID' => $iblockId,
                '=ID' => $sectionId,
            ],
        ]);

        if ($section = $result->fetch()) {
            $sectionCode = $section['CODE'];
        }

        return $sectionCode;
    }

    public static function getElementIdByCode($iblockId, $elementCode)
    {
        // Проверяем загрузку модуля инфоблоков
        if (!Loader::includeModule('iblock')) {
            return null; // Если модуль не загружен, возвращаем null или обрабатываем ошибку
        }

        $elementId = null;

        // Используем ORM для поиска элемента по символьному коду
        $result = ElementTable::getList([
            'select' => ['ID'],
            'filter' => [
                '=IBLOCK_ID' => $iblockId,
                '=CODE' => $elementCode,
            ],
        ]);

        if ($element = $result->fetch()) {
            // Если элемент найден, получаем его ID
            $elementId = $element['ID'];
        } else {
            $result = ElementTable::getList([
                'select' => ['ID'],
                'filter' => [
                    '=IBLOCK_ID' => $iblockId,
                    '=ID' => $elementCode,
                ],
            ]);
            $element = $result->fetch();
            $elementId = $element['ID'];
        }


        return $elementId;
    }

    /**
     * склонятор существительных после числа
     * @param $n - число, например 2
     * @param $form1 1 минута
     * @param $form2 2 минуты
     * @param $form3 (5, 10) минут
     * @return mixed
     */
    public static function pluralForm($n, $form1, $form2, $form3)
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) {
            return $form3;
        }
        if ($n1 > 1 && $n1 < 5) {
            return $form2;
        }
        if ($n1 == 1) {
            return $form1;
        }
        return $form3;
    }
}