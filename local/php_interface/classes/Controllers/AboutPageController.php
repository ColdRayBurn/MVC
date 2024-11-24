<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Services\AboutService;

class AboutPageController extends AboutService
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