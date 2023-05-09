<?php
session_start();
if (isset($_SESSION['Username'])) {
    $pageTitel = 'Dashboard';
    include 'init.php';

    $latestUser = 6; //Number Of Latest Users
    $theLatest = getLatest('*', 'users', 'UserID', $latestUser); // Latest Users Array

    /* Start Dashboard Page */
?>
    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members ">Total Members <span><a href="members.php"><?php echo countItem('UserID', 'users'); ?></a></span></div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">Pending Members <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0); ?></a></span></div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">Toal Items <span>1500</span></div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">Total Comments <span>3500</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest <?php echo $latestUser ?> Registerd Users
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                foreach ($theLatest as $user) {
                                    echo '<li>' . $user['Username'] . '
                                            <a href="members.php?do=Edit&userid=' . $user['UserID'] . '">
                                            <span class = "btn btn-success pull-right">
                                                <i class="fa fa-edit"></i>
                                                    Edit
                                            </span>
                                            </a> ';
                                    if ($user['RegStatus'] == 0) {
                                        echo '<a class="btn btn-info activate  pull-right" href="members.php?do=Activate&userid=' . $user['UserID'] . '">
                                        <i class="far fa-hourglass-half "></i> Activate</a>';
                                    }
                                    echo '</li>';
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fas fa-tag"></i> Latest Items
                        </div>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php
    /* End Dashboard Page */

    include $tpl . '/footer.php';
} else {
    echo 'you are not access here';
    header('Location: index.php');
    exit();
}
