<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$viewData = \Activitar\ViewData::getInstance();
$data = $viewData->getResult();
$params = $viewData->getParams();
?>

BLOG

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
