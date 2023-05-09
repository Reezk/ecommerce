<?php
function getTitle()
{
    global $pageTitel;
    if (isset($pageTitel)) {
        echo $pageTitel;
    } else {
        echo  'Defult';
    }
}
function redirectHome($theMsg, $url = null, $seconds = 3)
{
    if ($url === null) {
        $url = 'members.php';
    } else {
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'members.php';
    }
    echo $theMsg;
    echo "<div class='alert alert-info text-center'>You Will Be Directed To $url  Home After $seconds Seconds.</div>";
    header("Refresh:$seconds;URL=$url");
    exit();

    /* if ($typeMsg == 'success') {
        echo "<div class='alert alert-success'>$message</div>";
        echo "<div class='alert alert-info'>You Will Be Directed To Home After $seconds Seconds.</div>";
        header("Refresh:$seconds;url=members.php");
        exit();
    } elseif ($typeMsg == 'errore') {
        echo "<div class='alert alert-danger text-center'>$message</div>";
        echo "<div class='alert alert-info text-center'>You Will Be Directed To Home After $seconds Seconds.</div>";
        header("Refresh:$seconds;url=members.php");
        exit();
    } else {
        echo "<div class='alert text-center '>$message</div>";
        echo "<div class='alert text-center'>You Will Be Directed To Home After $seconds Seconds.</div>";
        header("Refresh:$seconds;url=members.php");
        exit();
    } */
}
//Chech Items Function
//Function to Check Item In Database
function checkItem($select, $from, $value)
{
    global $con;
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select =?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
    return $count;
}
/* 
* Count Number Of Items Function
* Function to Count Number Of Items ROws
*/
function countItem($item, $table)
{
    global $con;
    $stat2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $stat2->execute();
    return $stat2->fetchColumn();
}
/* 
*
*
 */

function getLatest($select, $table, $order, $limit = 3)
{
    global $con;

    $getStat = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStat->execute();
    $rows = $getStat->fetchAll();
    return $rows;
}
