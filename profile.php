<?php
ob_start();
session_start();
$pageTitel = 'Profile';
include "init.php";

if ($sessionUser) {
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();

    echo $info['Password']
?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Informatiion</div>
                <div class="panel-body">
                    Name: <?php echo $info['Username'] ?><br>
                    Email: <?php echo $info['Email'] ?><br>
                    Full Name: <?php echo $info['FullName'] ?><br>
                    Register Date: <?php echo $info['Date'] ?><br>
                    Favourit Categote: <?php echo $info['UserID'] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-ads block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Ads</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        foreach (getItems('MemberID', $info['UserID']) as $item) {
                            echo '<div class = "col-sm-6 col-sm-3">';
                            echo '<div class="thumbnail item-box">';
                            echo '<span class="price-tag">' . $item['Price'] . '    </span>';
                            echo '<img class="img-responsive" src="images.png" alt="">';
                            echo '<div class="caption">';

                            echo '<h3>' . $item['Name'] . '</h3>';
                            echo '<p>' . $item['Description'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my- block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Latest Coments</div>
                <div class="panel-body">
                    <?php
                    $stmt = $con->prepare("SELECT comment FROM comments WHERE user_ID = ?");
                    $stmt->execute(array($info['UserID']));
                    $comments = $stmt->fetchAll();
                    if (!empty($comments)) {
                        foreach ($comments as $comm) {
                            echo '<p>' . $comm['comment'] . '</p>';
                        }
                    } else {
                        echo "There's Not Comments To Show";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    header('Location: login.php');
    exit();
}
//Footer
include $tpl . '/footer.php';
ob_end_flush();
