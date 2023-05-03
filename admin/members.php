<?php
session_start();
$pageTitel = 'Members';
if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        //Manage Page
    } elseif ($do == 'Edit') {

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval(isset($_GET['userid'])) : 0;
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
            echo 'Good This Is The Form';
            // echo  '>0 ' . $count . '   ' . $_GET['userid'];
        } else {
            echo 'Theres No Such ID';
            // echo  is_numeric(isset($_GET['userid'])) .  $userid;
        }



?>
        <!-- echo ' Welcome ' . $_SESSION['Username'] . ' Your id is ' . $_GET['userid']; -->
        <h1 class="text-center">Edite Member</h1>
        <div class="container">
            <form action="" class="form-horizontal">
                <!-- Start Usename Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control" autocomplete="off">
                    </div>
                </div>
                <!-- End Usename Filed -->
                <!-- Start Password Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <!-- End Pssword Filed -->
                <!-- Start Email Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
                <!-- End Email Filed -->
                <!-- Start Full Name Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control">
                    </div>
                </div>
                <!-- End Full Name Filed -->
                <!-- Start button save Filed -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        <input type="submit" value="save" class="btn btn-primary">
                    </div>
                </div>
                <!-- End button save Filed -->
            </form>
        </div>
<?php }




    include $tpl . '/footer.php';
} else {
    header('Location: index.php');
    exit();
}
