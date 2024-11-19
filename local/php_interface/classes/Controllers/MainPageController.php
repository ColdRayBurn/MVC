<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Dto\SelectionsDTO;
use Activitar\OptionsData;
use Activitar\Services\ListObjectService;
use Activitar\Services\MainService;
use Activitar\Services\SelectionsService;
use Activitar\Services\NewsService;

class MainPageController extends MainService
{
    use ApiCore;

    protected function getMetaAction(): void
    {
        $this->executeApi();
        $this->sendDataToView(
            ['data' => ['ELEMENT1', 'ELEMENT2', 'ELEMENT3', 'ELEMENT4', 'ELEMENT5', 'ELEMENT7',],
            ]
            , []
        );
    }

}