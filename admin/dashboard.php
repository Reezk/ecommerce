<?php
ob_start(); //Output Buffering Start
session_start();
if (isset($_SESSION['Username'])) {
    $pageTitel = 'Dashboard';
    include 'init.php';

    $numUsers = 6; //Number Of Latest Users
    $latestUsers = getLatest('*', 'users', 'UserID', $numUsers); // Latest Users Array
    $numItems = 3; //Number Of Latest Items
    $latestItems = getLatest('*', 'items', 'ItemID', $numItems); // Latest Items Array

    /* Start Dashboard Page */
?>
    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members ">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                            <span>
                                <a href="members.php">
                                    <?php echo countItem('UserID', 'users'); ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            Pending Members
                            <span>
                                <a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        <i class="fa fa-tags"></i>
                        <div class="info">
                            Toal Items
                            <span>
                                <a href="items.php"><?php echo countItem('ItemID', 'items'); ?></a>
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total Comments
                            <span>40</span>
                        </div>
                    </div>
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
                            <i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Registerd Users
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                foreach ($latestUsers as $user) {
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
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                foreach ($latestItems as $item) {
                                    echo '<li>' . $item['Name'] . '
                                            <a href="items.php?do=Edit&itemid=' . $item['ItemID'] . '">
                                            <span class = "btn btn-success pull-right">
                                                <i class="fa fa-edit"></i>
                                                    Edit
                                            </span>
                                            </a> ';
                                    if ($item['Approve'] == 0) {
                                        echo '<a class="btn btn-info activate  pull-right" href="items.php?do=Approve&itemid=' . $item['ItemID'] . '">
                                        <i class="fa fa-check "></i> Approve</a>';
                                    }
                                    echo '</li>';
                                }

                                ?>
                            </ul>
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
ob_end_flush(); //Relase the Output
