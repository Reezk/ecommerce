<?php
/* 
===========================
=== Items Page
== You can Edit | Delete | Approve Comments From Here
===========================
*/
ob_start();
session_start();
$pageTitel = 'Comments';
if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //start manage page
    if ($do == 'Manage') {


        $stmt = $con->prepare("SELECT  
                                comments.*,items.Name AS item_name,users.Username AS member
                                FROM 
                                comments
                                INNER JOIN
                                items
                                ON
                                items.itemID = comments.item_ID
                                INNER JOIN
                                users
                                ON
                                users.userID = comments.user_ID
                                ORDER BY commID DESC");
        $stmt->execute();
        $comments = $stmt->fetchAll();
        if (!empty($comments)) {

?>
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="tabel-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Comments</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                        <?php foreach ($comments as  $comment) {
                            echo '
                        <tr>
                            <td>' . $comment['commID'] . '</td>
                            <td>' . $comment['comment'] . '</td>
                            <td>' . $comment['item_name'] . '</td>
                            <td>' . $comment['member'] . '</td>
                            <td>' . $comment['commDate'] . '</td>
                            <td>
                                <a class="btn btn-success" href="comments.php?do=Edit&commid=' . $comment['commID'] . '"><i class ="fa fa-edit"></i> Edit</a>
                                <a class="btn btn-danger confirm" href="comments.php?do=Delete&commid=' . $comment['commID'] . '"><i class ="fa fa-close"></i> Delete</a>';
                            if ($comment['status'] == 0) {
                                echo '<a class="btn btn-info activate" href="comments.php?do=Approve&commid=' . $comment['commID'] . '"><i class="fa fa-check"></i> Approve</a>';
                            }
                            echo '</td>
                        </tr>
                        ';
                        } ?>
                    </table>
                </div>
            <?php
        } else {
            echo '<div class = "container">';
            echo '<div class="nice-message">There\' No Comments To Show</div>';
            echo '</div>';
        }
        echo '</div>';
    } elseif ($do == 'Edit') {

        $commid = (isset($_GET['commid']) && is_numeric($_GET['commid'])) ? intval($_GET['commid']) : 0;
        $stmt = $con->prepare("SELECT * FROM comments WHERE commID = ?");
        $stmt->execute(array($commid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

            ?>
            <h1 class="text-center">Edite Comment</h1>
            <div class="container">
                <?php if ($stmt->rowCount() > 0) { ?>
                    <form action="?do=Update" method="POST" class="form-horizontal">
                        <input type="hidden" name="commid" value="<?php echo $commid ?>">
                        <!-- Start Comment Filed -->
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10 col-md-6">
                                <!-- <input type="text" name="comment" class="form-control " value="<?php echo $row['comment'] ?>" autocomplete="off" required='required'> -->
                                <textarea name="comment" class="form-control"><?php echo $row['comment'] ?></textarea>
                            </div>
                        </div>
                        <!-- End Comment Filed -->

                        <!-- Start button save Filed -->
                        <div class=" form-group">
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
            $commid = $_POST['commid'];
            $comment = $_POST['comment'];


            $stmt = $con->prepare("UPDATE comments SET comment=? WHERE commID = ?");
            $stmt->execute(array($comment, $commid));

            $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Update</div>';
            redirectHome($successMsg,  50);
        } else {
            $errorMsg =  '<div class="alert alert-danger text-center">You Cant Browser The Pge Directly</div>';
            redirectHome($errorMsg,  3);
        }
        echo "</div>";
    } elseif ($do == "Delete") {
        echo "<h1 class = 'text-center'>Delete Comment</h1>";
        echo "<div class = 'container'>";
        $commid = (isset($_GET['commid']) && is_numeric($_GET['commid'])) ? intval($_GET['commid']) : 0;

        $chek = checkItem('commID', 'comments', $commid);

        if ($chek > 0) {
            $stmt = $con->prepare("DELETE FROM comments WHERE commID = :zcomm");
            $stmt->bindParam(":zcomm", $commid);
            $stmt->execute();
            $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($successMsg,  6);
        } else {
            $errorMsg = '<div class="alert alert-danger text-center"> The ID Is not Exist</div>';;
            redirectHome($errorMsg,  6);
        }
        echo "</div>";
    } elseif ($do == "Approve") {
        echo "<h1 class = 'text-center'>Approve Comments</h1>";
        echo "<div class = 'container'>";
        $commid = (isset($_GET['commid']) && is_numeric($_GET['commid'])) ? intval($_GET['commid']) : 0;
        $chek = checkItem('commID', 'comments', $commid);

        if ($chek > 0) {
            $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE commID = ?");
            $stmt->execute(array($commid));
            $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Approved</div>';
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
