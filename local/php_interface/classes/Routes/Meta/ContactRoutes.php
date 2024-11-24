<?php

namespace Activitar\Routes\Meta;

use Activitar\Controllers\ContactPageController;
use Activitar\Errors;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Routing\RoutingConfigurator;

class ContactRoutes extends ContactPageController
{
    use Errors;
    public function getMetaRoute(RoutingConfigurator $routes)
    {
        $routes
            ->name('contact')
            ->any('/contact/', function (HttpRequest $request) {
                $this->getMetaAction();
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/contact.php")) {
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/contact.php");
                }else{
                    $this->set404();
                }
            })->methods(['GET']);
    }

}