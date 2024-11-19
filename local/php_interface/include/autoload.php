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
        'Activitar\\Exceptions\\NonCriticalException' => '/local/php_interface/classes/exceptions/NonCriticalException.php',

        //ROUTESS
        'Activitar\\Routes\\Meta\\MainRoutes' => '/local/php_interface/classes/Routes/Meta/MainRoutes.php',


        //CONTROLLERS
        'Activitar\\Controllers\\MainPageController' => '/local/php_interface/classes/Controllers/MainPageController.php',


        //SERVICES
        'Activitar\\Services\\MainService' => '/local/php_interface/classes/Services/MainService.php',


        //MODELS


        //DTO


    )
);
?>