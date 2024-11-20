<?php

namespace Activitar;


use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Loader;

class Helper
{


    public static function getCleanUrl(): string
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        $uri = new \Bitrix\Main\Web\Uri($request->getRequestUri());
        return strtok($uri->getUri(), '?');
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
        if (!Loader::includeModule('iblock')) {
            return null;
        }

        $elementId = null;

        $result = ElementTable::getList([
            'select' => ['ID'],
            'filter' => [
                '=IBLOCK_ID' => $iblockId,
                '=CODE' => $elementCode,
            ],
        ]);

        if (!$element = $result->fetch()) {
            $result = ElementTable::getList([
                'select' => ['ID'],
                'filter' => [
                    '=IBLOCK_ID' => $iblockId,
                    '=ID' => $elementCode,
                ],
            ]);
            $element = $result->fetch();
        }

        return $element['ID'];
    }
}