<?php

include 'connect.php';
//Routes

$tpl = 'includes/templates/'; //Templet Dirctiory
$lang = 'includes/languages/';
$func = 'includes/functions/';
$css = 'layout/css/'; // Css Dirctory
$js = 'layout/js/'; // Js Dirctory


//Include the important files

//Functions
include $func . '/functions.php';
//language
include $lang . '/english.php';
//Header
include $tpl . '/header.php';

if (!isset($noNavbar)) {
    include $tpl . 'navbar.php';
}
