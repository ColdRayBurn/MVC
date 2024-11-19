<?php
namespace Activitar;

trait Errors
{
    public function set404(): never
    {
        global $APPLICATION;

        if (!defined("ERROR_404")) {
            define("ERROR_404", "Y");
        }

        \CHTTP::setStatus("404 Not Found");
        $APPLICATION->RestartWorkarea();
        require(\Bitrix\Main\Application::getDocumentRoot() . "/404.php");
        exit();
    }

}