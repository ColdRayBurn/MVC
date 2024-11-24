<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/autoload.php')) {
    require($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/autoload.php');
}

use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    // Main Page
    $publicRouterObject = new \Activitar\Routes\Meta\MainRoutes();
    $publicRouterObject->getMetaRoute($routes);

    // About Page
    $publicRouterObject = new \Activitar\Routes\Meta\AboutRoutes();
    $publicRouterObject->getMetaRoute($routes);

    // Blog Page
    $publicRouterObject = new \Activitar\Routes\Meta\BlogRoutes();
    $publicRouterObject->getMetaRoute($routes);

    // Contact Page
    $publicRouterObject = new \Activitar\Routes\Meta\ContactRoutes();
    $publicRouterObject->getMetaRoute($routes);

    // Gallery Page
    $publicRouterObject = new \Activitar\Routes\Meta\GalleryRoutes();
    $publicRouterObject->getMetaRoute($routes);

    // Schedule Page
    $publicRouterObject = new \Activitar\Routes\Meta\ScheduleRoutes();
    $publicRouterObject->getMetaRoute($routes);
};



