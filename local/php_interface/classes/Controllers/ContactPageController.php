<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Services\ContactService;

class ContactPageController extends ContactService
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