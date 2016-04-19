<?php

require_once('View/HtmlView.php');
require_once('Controller/MainController.php');
//require_once('./Controller/LoginController.php');

session_start();

//main layout
$htmlView = new \View\HTMLView();

//page content
$mainController = new \Controller\MainController();
$content = $mainController->controlNavigation();

$htmlView->echoHTML($content);