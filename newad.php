<?php
ob_start();
session_start();
$pageTitel = 'Create New Ad';
include "init.php";
if ($sessionUser) {
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $formErrors = array();

      $title = strip_tags(filter_var($_POST['name'], FILTER_UNSAFE_RAW));
      $description = strip_tags(filter_var($_POST['description'], FILTER_UNSAFE_RAW));
      $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
      $contry = strip_tags(filter_var($_POST['contry'], FILTER_UNSAFE_RAW));
      $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
      $categories = filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);
      if (strlen($title) < 4) {
         $formErrors[] = 'Item Titel Must Be At Least 4 Character';
      }
      if (strlen($description) < 10) {
         $formErrors[] = 'Item Description Must Be At Least 10 Character';
      }
      if (strlen($contry) < 2) {
         $formErrors[] = 'Item contry Must Be At Least 4 Character';
      }
      if (strlen($contry)) {
         $formErrors[] = '';
      }
      if (empty($price)) {
         $formErrors[] = 'Item price Must Be Not Empty';
      }
      if (empty($status)) {
         $formErrors[] = 'Item Status Must Be Not Empty';
      }
      if (empty($categories)) {
         $formErrors[] = 'Item Categories Must Be Not Empty';
      }
      if (!empty($formErrors)) {
         $stmt = $con->prepare("INSERT INTO 
               items(Name,Description,Price,CountryMade,Status,MemberID,CatID)
               VALUES(:zname,:zdesc,:zprice,:zmade,:zstatus,:zmemberid,:zcatid)");

         $stmt->execute(array(

            'zname'     => $title,
            'zdesc'     => $description,
            'zprice'    => $price,
            'zmade'     => $contry,
            'zstatus'   => $status,
            'zcatid'    => $categories,
            'zmemberid' => $_SESSION['uid'],

         ));
         if ($stmt) {
            echo 'Item Added';
         }
      }
   }
?>
   <h1 class="text-center"><?php echo $pageTitel ?></h1>
   <div class="create-ad block">
      <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $pageTitel ?></div>
            <div class="panel-body">
               <div class="col-md-8">
                  <h1 class="text-center"><?php echo $pageTitel ?></h1>
                  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal main-form">
                     <!-- Start Name Filed -->
                     <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-9">
                           <input type="text" name="name" class="form-control live" placeholder="Name Of The Item" data-class=".live-title">
                        </div>
                     </div>
                     <!-- End Name Filed -->
                     <!-- Start Description Filed -->
                     <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-9">
                           <input type="text" name="description" class="form-control live" placeholder="Describe The Item" data-class=".live-desc">
                        </div>
                     </div>
                     <!-- End Description Filed -->
                     <!-- Start Price Filed -->
                     <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-9">
                           <input type="text" name="price" class="form-control live" placeholder="Price Of The Item" data-class=".live-price">
                        </div>
                     </div>
                     <!-- End Price Filed -->
                     <!-- Start Contry Made Filed -->
                     <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Contry Made</label>
                        <div class="col-sm-10 col-md-9">
                           <input type="text" name="contry" class="form-control" placeholder="Contry Made Of The Item">
                        </div>
                     </div>
                     <!-- End Contry Made Filed -->
                     <!-- Start Status Filed -->
                     <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-9">
                           <select class="" name="status" id="">
                              <option value="">...</option>
                              <option value="1">New</option>
                              <option value="2">Like New</option>
                              <option value="3">Used</option>
                              <option value="4">Very Old</option>
                           </select>
                        </div>
                     </div>
                     <!-- End Status Filed -->
                     <!-- Start Categories Filed -->
                     <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Categories</label>
                        <div class="col-sm-10 col-md-9">
                           <select class="" name="categories" id="">
                              <option value="0">...</option>
                              <?php
                              $stmt2 = $con->prepare("SELECT * FROM categories");
                              $stmt2->execute();
                              $cats = $stmt2->fetchAll();
                              foreach ($cats as $cat) {
                                 echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <!-- End Members Filed -->
                     <!-- Start button  Filed -->
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 ">
                           <input type="submit" value="Add Item" class="btn btn-primary btn-sm">
                        </div>
                     </div>
                     <!-- End button  Filed -->
                  </form>
               </div>
               <div class="col-md-4">
                  <div class="thumbnail item-box live-preview">
                     <span class="price-tag ">$<span class="live-price">0</span></span>
                     <img class="img-responsive" src="images.png" alt="">
                     <div class="caption">
                        <h3 class="live-title">Titel</h3>
                        <p class="live-desc">Discription</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- start looping through errors -->
            <?php if (!empty($formErrors)) {
               foreach ($formErrors as $error) {
                  echo '<div class="alert alert-danger">' . $error . '</div>';
               }
            } ?>
            <!-- end looping through errors -->
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
