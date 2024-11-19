<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");

?>
        <section class="page-error">
            <div class="container">
                <div class="page-error__image">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/404.png" alt="alt">
                </div>
            </div>
        </section>
<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>