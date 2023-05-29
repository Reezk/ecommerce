<?php
ob_start();
session_start();
$pageTitel = 'Show Items';
include "init.php";


//chick if get request itemid  is numeric & get its integer   value
$itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
$stmt = $con->prepare(" SELECT 
										items.*,
										categories.Name AS CatName,
										users.Username AS UserName
								FROM 
										items
								INNER JOIN
										categories
								ON
										categories.ID = items.CatID
								INNER JOIN
										users
								ON
										users.UserID = items.MemberID
								WHERE ItemID = ?
                        AND Approve = 1");
$stmt->execute(array($itemid));
$item   = $stmt->fetch();
$count = $stmt->rowCount();

if ($count > 0) {

?>
   <h1 class="text-center"><?php echo $item['Name']; ?></h1>
   <div class="container">
      <div class="row">
         <div class="col-md-3">
            <img class="img-responsive img-thumbnail center-block" src="<?php echo $img ?>images.png" alt="">
         </div>
         <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class='list-unstyled'>
               <li>
                  <i class="fa fa-calendar fa-fw"></i>
                  <span> Adedd Date </span>: <?php echo $item['AddDate'] ?>
               </li>
               <li>
                  <i class="fa fa-money-bill fa-fw"></i>
                  <span> Price </span>: $<?php echo $item['Price'] ?>
               </li>
               <li>
                  <i class="fa fa-building fa-fw"></i>
                  <span> Made </span>: <?php echo $item['CountryMade'] ?>
               </li>
               <li>
                  <i class="fa fa-tags fa-fw"></i>
                  <span> Category </span>: <a href='categories.php?pageid=<?php echo $item['CatID'] ?>'><?php echo $item['CatName'] ?></a>
               </li>
               <li>
                  <i class="fa fa-user fa-fw"></i>
                  <span> Added By </span>: <a href="member.php?memberid="><?php echo $item['UserName'] ?></a>
               </li>
            </ul>
         </div>
      </div>
      <hr class='custom-hr'>
      <?php if (isset($_SESSION['user'])) {
      ?>
         <div class="row">
            <!-- start add comment -->
            <div class="col-md-offset-3">
               <div class="add-comment">
                  <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['ItemID'] ?>" method="POST">
                     <h3>Add Your Comment</h3>
                     <textarea class='form-contrlo' name="comment" required="required"></textarea>
                     <input class=" btn btn-primary" type="submit" value="Add Comment">
                  </form>
                  <?php
                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                     $comment = strip_tags(filter_var($_POST['comment'], FILTER_UNSAFE_RAW));
                     $userid = $_SESSION['uid'];
                     $itemid = $item['ItemID'];

                     if (!empty($comment)) {
                        $stmt = $con->prepare("INSERT INTO 
                                                comments(comment,status,commDate,item_ID,user_ID)
                                                VALUES(:zcomm,0,now(),:zitemid,:zuserid)
                                                ");
                        $stmt->execute(array(
                           'zcomm'   => $comment,
                           'zitemid' => $itemid,
                           'zuserid' => $userid,
                        ));
                        if ($stmt) {
                           echo '<div class = "alert alert-success">Comment Added</div>';
                        }
                     } else {

                        echo '<div class = "alert alert-danger">The Comment Is Empty</div>';
                     }
                  }
                  ?>
               </div>
            </div>
         </div>
         <!-- end add comment -->
      <?php   } else {
         echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
      } ?>
      <hr class='custom-hr'>
      <?php
      $stmt = $con->prepare(" SELECT
                                       comments.*,
                                       users.Username AS member
                                 FROM
                                       comments
                                 INNER JOIN
                                       users
                                 ON
                                       users.UserID = comments.user_ID
                                 WHERE
                                       item_ID = ?
                                 AND 
                                       status = 1
                                 ORDER BY commID DESC 
                              ");
      $stmt->execute(array($itemid));
      $comments = $stmt->fetchAll();

      ?>
      <div class=" row">
         <div class="col-md-9">
            <?php
            if (!empty($comments)) {
               foreach ($comments as $comment) {
            ?>
                  <div class="comment-box">
                     <div class="row">
                        <div class="col-sm-2 text-center">
                           <img class="img-responsive img-thumbnail img-circle center-block" src="<?php echo $img ?>/images.png" alt="images">
                           <?php echo $comment['member'] ?>
                        </div>

                        <div class="col-sm-10">
                           <p class="lead"><?php echo $comment['comment'] ?></p>
                        </div>
                     </div>
                  </div>
                  <hr class="custom-hr">
            <?php
               }
            }
            ?>
         </div>
      </div>
   </div>
<?php
} else {
   echo '<div class="container">';
   $theMsg = '<div class = "alert alert-danger text-center">there is not such ID Or This Item Is Waiting Approval</div>';
   redirectHome($theMsg, 'back');
   echo '</div>';
}
//Footer
include $tpl . '/footer.php';
ob_end_flush();
