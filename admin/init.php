<?php

include 'connect.php';
//Routes

$tpl = 'includes/templates/'; //Templet Dirctiory
$css = 'layout/css/'; // Css Dirctory
$js = 'layout/js/'; // Js Dirctory
$lang = 'includes/languages/';


//Include the important files

//language
include $lang . '/english.php';
//Header
include $tpl . '/header.php';

if (!isset($noNavbar)) {
    include $tpl . 'navbar.php';
}
