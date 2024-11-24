<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Services\ScheduleService;


class SchedulePageController extends ScheduleService
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