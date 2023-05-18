<?php
session_start();
$pageTitel = 'Login';
include 'init.php';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}


//Check If User Coming From HTTP Post Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashedPass = sha1($pass);
        // echo $user . ' ' . $hashedPass;
        //Check If The User Exist In Database
        $stmt = $con->prepare("SELECT Username,Password FROM users WHERE Username= ? AND Password = ?");
        $stmt->execute(array($user, $hashedPass));
        $count = $stmt->rowCount();
        if ($count > 0) {
            // echo 'Welcome Admin ' . $username;
            $_SESSION['user'] = $user; //Register Session Name
            header('Location: index.php');
            exit();
        }
    } else {
        $formErrors = array();
        if (isset($_POST['username'])) {
            $filterdUser = strip_tags(filter_var($_POST['username'], FILTER_UNSAFE_RAW));
            if (strlen($filterdUser) < 4) {
                $formErrors[] = 'Username Must Be Larger Than 4 Characters';
            }
            if (strlen($filterdUser) > 20) {
                $formErrors[] = 'Username Must Be Less Than 20 Characters';
            }
        }
        if (isset($_POST['password']) && isset($_POST['password-agin'])) {

            $pass = sha1(isset($_POST['password']));
            $pass2 = sha1(isset($_POST['password-agin']));

            if ($pass !== $pass2) {
                $formErrors[] = 'Sorry Password Is Not Match';
            }
        }
    }
}

?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span>
    </h1>
    <!-- Start Login Form -->
    <form action="" class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
            <input class="form-control" name="username" type="text" placeholder="Type Your Username" autocomplete="off" required="required">
        </div>
        <div class="input-container">
            <input class="form-control" name="password" type="password" placeholder="Type Your Password" autocomplete="new-password" required="required">
        </div>
        <input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
    </form>
    <!-- End Login Form -->
    <!-- Start signup Form -->
    <form action="" class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
            <input class="form-control" name="username" type="text" placeholder="Type Your Userbame" autocomplete="off" ">
        </div>
        <div class=" input-container">
            <input class="form-control" name="password" type="password" placeholder="Type a complex Password" autocomplete="new-password" ">
        </div>
        <div class=" input-container">
            <input class="form-control" name="password-agin" type="password" placeholder="Type a Password agine" autocomplete="new-password" ">
        </div>
        <div class=" input-container">
            <input class="form-control" name="email" type="email" placeholder="Type a valid email" ">
        </div>
        <div class=" input-container">
            <input class="btn btn-success btn-block" name="signup" type="submit" value="Signup">
        </div>
    </form>
    <!-- End signup Form -->
    <div class="the-errors text-center">
        <?php
        if (!empty($formErrors)) {

            foreach ($formErrors as $error) {
                echo $error . '<br>';
            }
        }

        ?>
    </div>
</div>
<?php include $tpl . '/footer.php' ?>