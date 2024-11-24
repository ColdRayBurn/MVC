<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Services\BlogService;


class BlogPageController extends BlogService
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