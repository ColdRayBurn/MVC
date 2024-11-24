<?php
CModule::AddAutoloadClasses(
    '',
    array(
        'IBlockData' => '/local/php_interface/classes/Iblock-data/IBlockData.php',
        'Activitar\\ApiCore' => '/local/php_interface/classes/ApiCore.php',
        'Activitar\\ViewData' => '/local/php_interface/classes/ViewData.php',
        'Activitar\\Helper' => '/local/php_interface/classes/Helper.php',
        'Activitar\\Errors' => '/local/php_interface/classes/Errors.php',
        'Activitar\\RouteHelper' => '/local/php_interface/classes/RouteHelper.php',
        'Activitar\\IblockHelper' => '/local/php_interface/classes/IblockHelper.php',
        'Activitar\\Exceptions\\NonCriticalException' => '/local/php_interface/classes/exceptions/NonCriticalException.php',


        //ROUTESS
        'Activitar\\Routes\\Meta\\MainRoutes' => '/local/php_interface/classes/Routes/Meta/MainRoutes.php',
        'Activitar\\Routes\\Meta\\AboutRoutes' => '/local/php_interface/classes/Routes/Meta/AboutRoutes.php',
        'Activitar\\Routes\\Meta\\BlogRoutes' => '/local/php_interface/classes/Routes/Meta/BlogRoutes.php',
        'Activitar\\Routes\\Meta\\ContactRoutes' => '/local/php_interface/classes/Routes/Meta/ContactRoutes.php',
        'Activitar\\Routes\\Meta\\GalleryRoutes' => '/local/php_interface/classes/Routes/Meta/GalleryRoutes.php',
        'Activitar\\Routes\\Meta\\ScheduleRoutes' => '/local/php_interface/classes/Routes/Meta/ScheduleRoutes.php',


        //CONTROLLERS
        'Activitar\\Controllers\\MainPageController' => '/local/php_interface/classes/Controllers/MainPageController.php',
        'Activitar\\Controllers\\AboutPageController' => '/local/php_interface/classes/Controllers/AboutPageController.php',
        'Activitar\\Controllers\\BlogPageController' => '/local/php_interface/classes/Controllers/BlogPageController.php',
        'Activitar\\Controllers\\ContactPageController' => '/local/php_interface/classes/Controllers/ContactPageController.php',
        'Activitar\\Controllers\\GalleryPageController' => '/local/php_interface/classes/Controllers/GalleryPageController.php',
        'Activitar\\Controllers\\SchedulePageController' => '/local/php_interface/classes/Controllers/SchedulePageController.php',


        //SERVICES
        'Activitar\\Services\\MainService' => '/local/php_interface/classes/Services/MainService.php',
        'Activitar\\Services\\AboutService' => '/local/php_interface/classes/Services/AboutService.php',
        'Activitar\\Services\\BlogService' => '/local/php_interface/classes/Services/BlogService.php',
        'Activitar\\Services\\ContactService' => '/local/php_interface/classes/Services/ContactService.php',
        'Activitar\\Services\\GalleryService' => '/local/php_interface/classes/Services/GalleryService.php',
        'Activitar\\Services\\ScheduleService' => '/local/php_interface/classes/Services/ScheduleService.php',


        //MODELS


        //DTO


    )
);
?>