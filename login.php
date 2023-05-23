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
      $stmt = $con->prepare("SELECT UserID,Username,Password FROM users WHERE Username= ? AND Password = ?");
      $stmt->execute(array($user, $hashedPass));
      $get = $stmt->fetch();
      $count = $stmt->rowCount();
      if ($count > 0) {
         // echo 'Welcome Admin ' . $username;
         $_SESSION['user'] = $user; //Register Session Name
         $_SESSION['uid'] = $get['UserID']; //Register User ID in Session 
         header('Location: index.php');
         exit();
      }
   } else {
      $formErrors = array();

      $username  = $_POST['username'];
      $password  = $_POST['password'];
      $password2 = $_POST['password-agin'];
      $email     = $_POST['email'];

      if (isset($username)) {
         $filterdUser = strip_tags(filter_var($username, FILTER_UNSAFE_RAW));
         if (strlen($filterdUser) < 4) {
            $formErrors[] = 'Username Must Be Larger Than 4 Characters';
         }
         if (strlen($filterdUser) > 20) {
            $formErrors[] = 'Username Must Be Less Than 20 Characters';
         }
         // checkItem('users', 'Username', $username);  
      }
      if (isset($password) && isset($password2)) {

         $pass = sha1($password);
         $pass2 = sha1($password2);
         if (empty(($password))) {
            $formErrors[] = 'Sorry Password Cant by Empty';
         }
         if ($pass !== $pass2) {
            $formErrors[] = 'Sorry Password Is Not Match';
         }
      }
      if (isset($email)) {
         $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
         if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
            $formErrors[] = 'This Email Is Not Valid';
         }
      }
      if (empty($formErrors)) {
         // check if user exist in database

         $chek = checkItem('Username', 'users', $username);
         if ($chek == 1) {
            $formErrors[] = 'This Username Is Exist';
         } else {
            $stmt = $con->prepare("INSERT INTO users(Username,Password,Email,RegStatus,Date) VALUES(:zuser,:zpass,:zmail,0,now())");
            $stmt->execute(array(
               'zuser' => $username,
               'zpass' => sha1($password),
               'zmail' => $email,
            ));

            echo '<div class = "container">';
            $successMsg = 'Congrats You Are Now Registerd User ';
            echo '</div>';
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
         <input class="form-control" name="username" type="text" placeholder="Type Your Userbame" autocomplete="off" pattern=".{4,20}" title="Usernme Cant be between 4 and 20 cars" "">
      </div>
      <div class=" input-container">
         <input class="form-control" name="password" type="password" placeholder="Type a complex Password" autocomplete="new-password" minlength="5" "">
      </div>
      <div class=" input-container">
         <input class="form-control" name="password-agin" type="password" placeholder="Type a Password agine" autocomplete="new-password" minlength="5" "">
      </div>
      <div class=" input-container">
         <input class="form-control" name="email" type="email" placeholder="Type a valid email" "">
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
            echo '<div class="msg error">' . $error . '</div>';
         }
      }
      if (isset($successMsg)) {
         echo '<div class="msg success">' . $successMsg . '</div>';
      }

      ?>
   </div>
</div>
<?php include $tpl . '/footer.php' ?>