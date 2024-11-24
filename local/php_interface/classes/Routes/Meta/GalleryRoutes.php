<?php

namespace Activitar\Routes\Meta;

use Activitar\Controllers\GalleryPageController;
use Activitar\Errors;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Routing\RoutingConfigurator;

class GalleryRoutes extends GalleryPageController
{
    use Errors;
    public function getMetaRoute(RoutingConfigurator $routes)
    {
        $routes
            ->name('gallery')
            ->any('/gallery/', function (HttpRequest $request) {
                $this->getMetaAction();
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/gallery.php")) {
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/gallery.php");
                }else{
                    $this->set404();
                }
            })->methods(['GET']);
    }

}