<?php
session_start();
$pageTitel = 'Members';
if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        echo 'hello in manage page';
        echo '<a href="members.php?do=Add">Add new Memeber</a>';
    } elseif ($do == 'Add') { ?>


        <h1 class="text-center">Add New Member</h1>
        <div class="container">
            <form action="?do=Insert" method="POST" class="form-horizontal">
                <!-- Start Usename Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control" autocomplete="off" required="require" placeholder="User Name to Login Shop">
                    </div>
                </div>
                <!-- End Usename Filed -->
                <!-- Start Password Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="password" class="form-control" required="require" placeholder="Password Must Be Hard & Complex">
                    </div>
                </div>
                <!-- End Pssword Filed -->
                <!-- Start Email Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control" required="require" placeholder="Email Muste Be Valid">
                    </div>
                </div>
                <!-- End Email Filed -->
                <!-- Start Full Name Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control" required="require" placeholder="Full Name Appear In Your Profile Page">
                    </div>
                </div>
                <!-- End Full Name Filed -->
                <!-- Start button save Filed -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        <input type="submit" value="Add Member" class="btn btn-primary">
                    </div>
                </div>
                <!-- End button save Filed -->
            </form>
        </div>

        <?php
    } elseif ($do == 'Insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<div class = 'container'>";

            echo "<h1 class = 'text-center'>Update Members</h1>";

            $id = $_POST['userid'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['full'];
            $pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);

            $formErrors = array();
            if (empty($username)) {
                $formErrors[] = 'User Name cant be empty';
            }
            if (strlen($username < 4)) {
                $formErrors[] = 'User Name cant be Less Than 4 characters';
            }
            if (empty($email)) {
                $formErrors[] = 'Email cant be empty';
            }
            if (empty($fullname)) {
                $formErrors[] = 'Full Name cant be empty';
            }
            foreach ($formErrors as $error) {
                echo '<div class ="alert alert-danger>' . $error . '</div>';
            }



            $stmt = $con->prepare("UPDATE users SET Username=? , Email = ?, FullName=?,Password = ? WHERE UserID = ?");
            $stmt->execute(array($username, $email, $fullname, $pass, $id));

            echo $stmt->rowCount() . ' Record updated' . $id . $pass . $email . $fullname;
        } else {
            echo 'You Cant Browser The Pge Directly';
        }
        echo "<div class = 'container'>";
    } elseif ($do == 'Edit') {

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval(isset($_GET['userid'])) : 0;
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($stmt->rowCount() > 0) { ?>

            <h1 class="text-center">Edite Member</h1>
            <div class="container">
                <form action="?do=Update" method="POST" class="form-horizontal">
                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <!-- Start Usename Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="require">
                        </div>
                    </div>
                    <!-- End Usename Filed -->
                    <!-- Start Password Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
                            <input type="password" name="newpassword" class="form-control">
                        </div>
                    </div>
                    <!-- End Pssword Filed -->
                    <!-- Start Email Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="require">
                        </div>
                    </div>
                    <!-- End Email Filed -->
                    <!-- Start Full Name Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="require">
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
        <?php
        } else {
            echo 'Theres No Such ID';
        }
        ?>
<?php
    } elseif ($do == 'Update') {
        echo "<h1 class = 'text-center'>Update Members</h1>";
        echo "<div class = 'container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['userid'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['full'];
            $pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);

            $formErrors = array();
            if (empty($username)) {
                $formErrors[] = '<div class ="alert alert-danger>User Name cant be <strong>empty</strong></div>';
            }
            if (strlen($username) < 4) {
                $formErrors[] = '<div class ="alert alert-danger>User Name cant be Less Than 4 characters<strong>Less Than 4 characters</strong></div>';
            }
            if (strlen($username) >  20) {
                $formErrors[] = '<div class ="alert alert-danger>User Name cant be More Than 20 characters<strong>Less Than 4 characters</strong></div>';
            }
            if (empty($email)) {
                $formErrors[] = '<div class ="alert alert-danger>Email cant be <strong></strong>empty</div>';
            }
            if (empty($fullname)) {
                $formErrors[] = '<div class ="alert alert-danger>Full Name cant be <strong>empty</strong></div>';
            }
            foreach ($formErrors as $error) {
                echo $error . '<br/>';
            }



            /*  $stmt = $con->prepare("UPDATE users SET Username=? , Email = ?, FullName=?,Password = ? WHERE UserID = ?");
            $stmt->execute(array($username, $email, $fullname, $pass, $id));

            echo $stmt->rowCount() . ' Record updated' . $id . $pass . $email . $fullname; */
        } else {
            echo 'You Cant Browser The Pge Directly';
        }
        echo "</div>";
    }
    include $tpl . '/footer.php';
} else {
    header('Location: index.php');
    exit();
}
