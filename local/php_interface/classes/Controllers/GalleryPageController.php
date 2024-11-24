<?php

namespace Activitar\Controllers;

use Activitar\ApiCore;
use Activitar\Services\GalleryService;


class GalleryPageController extends GalleryService
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