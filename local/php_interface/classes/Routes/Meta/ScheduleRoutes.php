<?php

namespace Activitar\Routes\Meta;

use Activitar\Controllers\SchedulePageController;
use Activitar\Errors;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Routing\RoutingConfigurator;

class ScheduleRoutes extends SchedulePageController
{
    use Errors;
    public function getMetaRoute(RoutingConfigurator $routes)
    {
        $routes
            ->name('schedule')
            ->any('/schedule/', function (HttpRequest $request) {
                $this->getMetaAction();
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/schedule.php")) {
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/View/schedule.php");
                }else{
                    $this->set404();
                }
            })->methods(['GET']);
    }

}