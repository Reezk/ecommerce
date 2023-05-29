<?php

ini_set('display_errore', 'On');
error_reporting(E_ALL);
include 'admin/connect.php';

$sessionUser = '';
if (isset($_SESSION['user'])) {
   $sessionUser = $_SESSION['user'];
}

//Routes
$tpl = 'includes/templates/'; //Templet Dirctiory
$lang = 'includes/languages/' ; //Lang Dirctory
$func = 'includes/functions/';//Function Dirctory
$css = 'layout/css/'; // Css Dirctory
$js = 'layout/js/'; // Js Dirctory
$img = 'layout/images/'; // img Dirctory


//Include the important files

//Functions
include $func . '/functions.php';
//language
include $lang . '/english.php';
//Header
include $tpl . '/header.php';
