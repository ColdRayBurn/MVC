<?php

namespace Activitar\Routes\Meta;

use Activitar\Controllers\BlogPageController;
use Activitar\Errors;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Routing\RoutingConfigurator;

class BlogRoutes extends BlogPageController
{
    use Errors;
    public function getMetaRoute(RoutingConfigurator $routes)
    {
        $routes
            ->name('blog')
            ->any('/blog/', function (HttpRequest $request) {
                $this->getMetaAction();
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/blog.php")) {
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/blog.php");
                }else{
                    $this->set404();
                }
            })->methods(['GET']);
    }

}