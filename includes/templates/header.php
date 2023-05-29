<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8" />
   <title><?php getTitle(); ?></title>
   <link rel="stylesheet" href='<?php echo $css ?>/bootstrap.min.css' />
   <!-- <link rel="stylesheet" href='<?php echo $css ?>/fontawesome.min.css' /> -->
   <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' />
   <link rel="stylesheet" href='<?php echo $css ?>/jquery-ui.css' />
   <link rel="stylesheet" href='<?php echo $css ?>/jquery.selectBoxIt.css' />
   <link rel="stylesheet" href='<?php echo $css ?>/fronend.css' />
</head>

<body>
   <div class="upper-bar">
      <div class="container">
         <?php
         if (isset($_SESSION['user'])) { ?>
            <img src="<?php echo $img ?>/images.png" class="my-img img-thumpnail img-circle" alt="">
            <div class="btn-group my-info">
               <span class="btn dropdown-toggle" data-toggle="dropdown">
                  <?php echo $sessionUser ?>
                  <span class="caret"></span>
               </span>
               <ul class="dropdown-menu">
                  <li><a href="profile.php">My Profile</a></li>
                  <li><a href="newad.php">New Item</a></li>
                  <li><a href="profile.php#my-ads">My Item</a></li>
                  <li><a href="logout.php">Logout</a></li>
               </ul>
            </div>

         <?php
         } else {
         ?>
            <a href="login.php">
               <span class="pull-right">Login/Signup</span>
            </a>
         <?php } ?>
      </div>
   </div>
   <nav class="navbar navbar-inverse">
      <div class="container">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapse" data-toggle='collapse' data-toggle="#app-nav" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand"><?php echo lang('HOME') ?></a>
         </div>
         <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav navbar-right">
               <?php
               foreach (getCategories() as $cat) {
                  echo '<li><a href="categories.php?pageid=' . $cat['ID'] . '">' . $cat['Name'] . '</a></li>';
               }
               ?>

            </ul>
         </div>
      </div>
   </nav>