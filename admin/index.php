<?php
session_start();
$noNavbar = '';
if (isset($_SESSION['Username'])) {
    header('Location: dashboard.php');
}
include "init.php";




//Check If User Coming From HTTP Post Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);
    //echo $username . ' ' . $hashedPass;
    //Check If The User Exist In Database
    $stmt = $con->prepare("SELECT Username,Password FROM users WHERE Username= ? AND Password = ? AND GroupID=1");
    $stmt->execute(array($username, $hashedPass));
    $count = $stmt->rowCount();
    echo $count;
    if ($count > 0) {
        // echo 'Welcome Admin ' . $username;
        $_SESSION['Username'] = $username; //Register Session Name
        header('Location: dashboard.php');
        exit();
    }
}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center"><?php echo lang('ADMIN_LOGIN') ?></h4>
    <input class="form-control input-lg" type="text" name="user" placeholder="<?php echo lang('USERNAME') ?>" autocomplete="off">
    <input class="form-control input-lg" type="password" name="pass" placeholder="<?php echo lang('PASSWORD') ?>" autocomplete="new-password">
    <input class="btn btn-primary btn-block btn-lg" type="submit" value="<?php echo lang('LOGIN') ?>">
</form>

<?php
//echo lang('MESSAGE') . ' ' . lang('HELLO');
?>

<?php
//Footer
include $tpl . '/footer.php';
?>