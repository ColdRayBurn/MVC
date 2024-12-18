<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Services\MainService;

class MainPageController extends MainService
{
    use ApiCore;

    protected function getMetaAction(): void
    {
        $this->executeApi();

        $this->sendDataToView(
            ['data' => $this->getData()],
            ['params' => 'params1']
        );
    }

}