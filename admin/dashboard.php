<?php
session_start();
if (isset($_SESSION['Username'])) {
    $pageTitel = 'Dashboard';
    include 'init.php';
    /* Start Dashboard Page */
?>
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat">Total Members <span>200</span></div>
                <div class="stat">Pending Members <span>20</span></div>
                <div class="stat">Total Members <span>1500</span></div>
                <div class="stat">Toal Items <span>3500</span></div>
            </div>
        </div>
    </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest Registerd Users
                    </div>
                    <div class="panel-body">
                        Test
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
