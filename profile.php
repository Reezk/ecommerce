<?php
ob_start();
session_start();
$pageTitel = 'Profile';
include "init.php";

if ($sessionUser) {
   $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
   $getUser->execute(array($sessionUser));
   $info = $getUser->fetch();

?>
   <h1 class="text-center">My Profile</h1>
   <div class="information block">
      <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">My Informatiion</div>
            <div class="panel-body">
               <ul class="list-unstyled">
                  <li>
                     <i class="fa fa-unlock-alt fa-fw"></i>
                     <span>Login Name</span>: <?php echo $info['Username'] ?>
                  </li>
                  <li>
                     <i class="fa fa-envelope fa-fw"></i>
                     <span> Email</span>: <?php echo $info['Email'] ?>
                  </li>
                  <li>
                     <i class="fa fa-user fa-fw"></i>
                     <span> Full Name</span>: <?php echo $info['FullName'] ?>
                  </li>
                  <li>
                     <i class="fa fa-calendar fa-fw"></i>
                     <span> Register Date</span>: <?php echo $info['Date'] ?>
                  </li>
                  <li>
                     <i class="fa fa-tags fa-fw"></i>
                     <span> Favourit Categote</span>: <?php echo $info['UserID'] ?>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div id="my-ads" class="my-ads block">
      <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">
               <div class="row">
                  <?php
                  if (!empty(getItems('MemberID', $info['UserID']))) {
                     foreach (getItems('MemberID', $info['UserID'], 1) as $item) {
                        echo '<div class = "col-sm-6 col-md-3">';
                        echo '<div class="thumbnail item-box">';
                        if ($item['Approve'] == 0) {
                           echo '<span class="approve-status">Waiting Approval</span>';
                        }
                        echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                        echo '<img class="img-responsive" src="' . $img . 'images.png" alt="">';
                        echo '<div class="caption">';
                        echo '<h3><a href="items.php?itemid=' . $item['ItemID'] . '">' . $item['Name'] . '</a></h3>';
                        echo '<p>' . $item['Description'] . '</p>';
                        echo '<p class ="date">' . $item['AddDate'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                     }
                  } else {
                     echo "There's Not Ads To Show ,Create <a href='newad.php'>New Ad</a>";
                  }
                  ?>
               </div>
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
