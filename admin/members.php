<?php
/* 
===========================
=== Items Page
===========================
*/
ob_start();
session_start();
$pageTitel = 'Members';
if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') {

        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            $query = ' AND RegStatus = 0';
        }
        $stmt = $con->prepare("SELECT * FROM users 
        WHERE GroupID !=1 ORDER BY Date DESC $query ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="tabel-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registed Date</td>
                            <td>Control</td>
                        </tr>
                        <?php foreach ($rows as  $row) {
                            echo '
                        <tr>
                            <td>' . $row['UserID'] . '</td>
                            <td>' . $row['Username'] . '</td>
                            <td>' . $row['Email'] . '</td>
                            <td>' . $row['FullName'] . '</td>
                            <td>' . $row['Date'] . '</td>
                            <td>
                                <a class="btn btn-success" href="members.php?do=Edit&userid=' . $row['UserID'] . '"><i class ="fa fa-edit"></i> Edit</a>
                                <a class="btn btn-danger confirm" href="members.php?do=Delete&userid=' . $row['UserID'] . '"><i class ="fa fa-close"></i> Delete</a>';
                            if ($row['RegStatus'] == 0) {
                                echo '<a class="btn btn-info activate" href="members.php?do=Activate&userid=' . $row['UserID'] . '"><i class="fa fa-check"></i> Activate</a>';
                            }
                            echo '</td>
                        </tr>
                        ';
                        } ?>
                    </table>
                </div>
                <a class="btn btn-success" href="members.php?do=Add"><i class="fa fa-plus"></i> New Memeber</a>
            <?php
        } else {
            echo '<div class = "container">';
            echo '<div class="nice-message">There\' No Members To Show</div>';

            echo '<a class="btn btn-success" href="members.php?do=Add"><i class="fa fa-plus"></i> New Memeber</a>';
            echo '</div>';
        }
        echo '</div>';
    } elseif ($do == 'Add') { ?>


            <h1 class="text-center">Add New Member</h1>
            <div class="container">
                <form action="?do=Insert" method="POST" class="form-horizontal">
                    <!-- Start Usename Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="username" class="form-control" autocomplete="off" placeholder="User Name to Login Shop" required='required'>
                        </div>
                    </div>
                    <!-- End Usename Filed -->
                    <!-- Start Password Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="password" name="password" class="form-control" placeholder="Password Must Be Hard & Complex" required='required'>
                            <i class="show-pass fa fa-eye fa-2x"></i>
                        </div>
                    </div>
                    <!-- End Pssword Filed -->
                    <!-- Start Email Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Email Muste Be Valid" required='required'>
                        </div>
                    </div>
                    <!-- End Email Filed -->
                    <!-- Start Full Name Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="full" class="form-control" placeholder="Full Name Appear In Your Profile Page" required='required'>
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

        echo "<div class = 'container'>";
        echo "<h1 class = 'text-center'>Update Members</h1>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['full'];
            $pass = $_POST['password'];

            $hashPass = sha1($_POST['password']);


            $formErrors = array();
            if (empty($username)) {
                $formErrors[] = 'User Name cant be <strong>Empty</strong>';
            }
            if (strlen($username) < 4) {
                $formErrors[] = 'User Name cant be <strong>Less Than 4 characters</strong>';
            }
            if (strlen($username) >  20) {
                $formErrors[] = 'User Name cant be <strong>More Than 20 characters</strong>';
            }
            if (empty($email)) {
                $formErrors[] = 'Email cant be <strong>Empty</strong>';
            }
            if (empty($pass)) {
                $formErrors[] = 'Password cant be <strong>Empty</strong>';
            }
            if (empty($fullname)) {
                $formErrors[] = 'Full Name cant be <strong>Empty</strong>';
            }
            foreach ($formErrors as $error) {
                echo '<div class ="alert alert-danger text-center" >' . $error . '</div>';
            }
            if (empty($formErrors)) {
                // check if user exist in database

                $chek = checkItem('Username', 'users', $username);
                if ($chek == 1) {
                    $thMsg = "<div class='alert alert-danger text-center'>Sorry This Usename Is Exist</div>";
                    redirectHome($thMsg, 'back');
                } else {
                    $stmt = $con->prepare("INSERT INTO users(Username,Password,Email,FullName,RegStatus,Date) VALUES(:zuser,:zpass,:zmail,:zname,1,now())");
                    $stmt->execute(array(
                        'zuser' => $username,
                        'zpass' => $hashPass,
                        'zmail' => $email,
                        'zname' => $fullname
                    ));

                    echo '<div class = "container">';
                    $successMsg = '<div class="alert alert-success text-center"> ' . $stmt->rowCount() . ' Record Insert' . '</div>';
                    redirectHome($successMsg, 'back');
                    echo '</div>';
                }
            }
        } else {
            $errorMsg =  '<div class="alert alert-danger text-center"> You Cant Browser The Pge Directly</div>';
            redirectHome($errorMsg, 6);
        }
        echo "</div>";
        echo "<div class = 'container'>";
    } elseif ($do == 'Edit') {

        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        ?>
            <h1 class="text-center">Edite Member</h1>
            <div class="container">
                <?php if ($stmt->rowCount() > 0) { ?>
                    <form action="?do=Update" method="POST" class="form-horizontal">
                        <input type="hidden" name="userid" value="<?php echo $userid ?>">
                        <!-- Start Usename Filed -->
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control " value="<?php echo $row['Username'] ?>" autocomplete="off" required='required'>
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
                                <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required='required'>
                            </div>
                        </div>
                        <!-- End Email Filed -->
                        <!-- Start Full Name Filed -->
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required='required'>
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
                    $errorMsg = '<div class="alert alert-danger text-center"> There Is No such ID</div>';
                    redirectHome($errorMsg,  6);
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
                $formErrors[] = '<div class ="alert alert-danger">User Name cant be <strong>empty</strong></div>';
            }
            if (strlen($username) < 4 && strlen($username) > 0) {
                $formErrors[] = '<div class ="alert alert-danger">User Name cant be <strong>Less Than 4 characters</strong></div>';
            }
            if (strlen($username) >  20) {
                $formErrors[] = '<div class ="alert alert-danger">User Name cant be <strong>Less Than 4 characters</strong></div>';
            }
            if (empty($email)) {
                $formErrors[] = '<div class ="alert alert-danger">Email cant be <strong></strong>empty</div>';
            }
            if (empty($fullname)) {
                $formErrors[] = '<div class ="alert alert-danger">Full Name cant be <strong>empty</strong></div>';
            }
            foreach ($formErrors as $error) {
                echo $error . ' <br/>';
            }
            if (empty($formErrors)) {
                $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                $stmt2->execute(array($username, $id));
                $count = $stmt2->rowCount();
                if ($count == 1) {
                    echo '<div class="alert alert-danger text-center">Sorry This User Is Exist</div>';
                    redirectHome($successMsg,  3);
                } else {
                    $stmt = $con->prepare("UPDATE users SET Username=? , Email = ?, FullName=?,Password = ? WHERE UserID = ?");
                    $stmt->execute(array($username, $email, $fullname, $pass, $id));

                    $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Update</div>';
                    redirectHome($successMsg,  3);
                }
            }
        } else {
            $errorMsg =  '<div class="alert alert-danger text-center">You Cant Browser The Pge Directly</div>';
            redirectHome($errorMsg,  3);
        }
        echo "</div>";
    } elseif ($do == "Delete") {
        echo "<h1 class = 'text-center'>Delete Members</h1>";
        echo "<div class = 'container'>";
        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
        /*  $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $count = $stmt->rowCount(); */
        $chek = checkItem('UserID', 'users', $userid);

        if ($chek > 0) {
            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
            $stmt->bindParam(":zuser", $userid);
            $stmt->execute();
            $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($successMsg, 'back');
        } else {
            $errorMsg = '<div class="alert alert-danger text-center"> The ID Is not Exist</div>';;
            redirectHome($errorMsg);
        }
        echo "</div>";
    } elseif ($do == "Activate") {
        echo "<h1 class = 'text-center'>Activate Members</h1>";
        echo "<div class = 'container'>";
        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;
        $chek = checkItem('UserID', 'users', $userid);

        if ($chek > 0) {
            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
            $stmt->execute(array($userid));
            $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Activated</div>';
            redirectHome($successMsg,  6);
        } else {
            $errorMsg = '<div class="alert alert-danger text-center"> The ID Is not Exist</div>';;
            redirectHome($errorMsg,  6);
        }
        echo "</div>";
    }
    include $tpl . '/footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
