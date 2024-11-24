<?php

namespace Activitar\Routes\Meta;

use Activitar\Controllers\AboutPageController;
use Activitar\Errors;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Routing\RoutingConfigurator;

class AboutRoutes extends AboutPageController
{
    use Errors;
    public function getMetaRoute(RoutingConfigurator $routes)
    {
        $routes
            ->name('about')
            ->any('/about/', function (HttpRequest $request) {
                $this->getMetaAction();
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/about.php")) {
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/about.php");
                }else{
                    $this->set404();
                }
            })->methods(['GET']);
    }

}