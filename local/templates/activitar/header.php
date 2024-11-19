<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

CModule::IncludeModule('iblock');
global $APPLICATION;
global $USER;
$APPLICATION->ShowHead();

if ($USER->IsAdmin()) {
    $APPLICATION->ShowPanel();
}

?><!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Activitar Template">
    <meta name="keywords" content="Activitar, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activitar | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/style.css" type="text/css">
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="logo">
            <a href="./index.html">
                <img src="<?= SITE_TEMPLATE_PATH ?>/img/logo.png" alt="">
            </a>
        </div>
        <div class="top-social">
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="container">
            <div class="nav-menu">
                <nav class="mainmenu mobile-menu">
                    <ul>
                        <li class="active"><a href="./index.html">Home</a></li>
                        <li><a href="./about-us.html">About us</a></li>
                        <li><a href="./schedule.html">Schedule</a></li>
                        <li><a href="./gallery.html">Gallery</a></li>
                        <li><a href="./blog.html">Blog</a>
                            <ul class="dropdown">
                                <li><a href="./about-us.html">About Us</a></li>
                                <li><a href="./blog-single.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="./contact.html">Contacts</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>