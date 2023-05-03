<?php
session_start();
if (isset($_SESSION['Username'])) {
    $pageTitel = 'Dashboard';
    include 'init.php';

    echo ' Welcome ' . $_SESSION['Username'];
    include $tpl . '/footer.php';
} else {
    // echo 'you are not access here';
    header('Location: index.php');
    exit();
}
