<?php
session_start();
$pageTitel = 'Homepage';
include "init.php";
$stmt = $con->prepare("SELECT * FROM items");
$stmt->execute();

?>

<?php
//Footer
include $tpl . '/footer.php';
