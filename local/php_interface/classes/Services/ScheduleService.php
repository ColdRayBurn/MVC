<?php

namespace Activitar\Services;

use Activitar\Errors;
use Activitar\IblockHelper;

class ScheduleService
{
    use IblockHelper;
    use Errors;

    public function getData()
    {
        $selectArray = ['TEXT', 'HTML', 'NUMBER', 'ENUM', 'MULTUPLE_ENUM', 'FILE', 'MULTUPLE_FILE', 'ELEMENT_LINK', 'DATE', 'DATETIME'];
        $enumsArray = ['MULTUPLE_ENUM', 'ENUM'];
        $multiplePropsArray = ['MULTUPLE_ENUM' => ['MULTUPLE_ENUM.VALUE'], 'MULTUPLE_FILE' => ['MULTUPLE_FILE.VALUE']];
        $filterArray = ['ELEMENT_LINK.VALUE' => 189167];

        $this->initIblockHelper(new \Bitrix\Iblock\Elements\ElementMainPageTable);

        $data = $this->getDataFormTable(
            select: $selectArray, filter: $filterArray, cache: true, multiplePropsIdArray: $multiplePropsArray
        );

        $enums = $this->getEnumProperty($enumsArray);
        self::fillEnumProperties($data, $enums);

        return $data;
    }

}