<?php
session_start();
$pageTitel = 'Categories';
include "init.php"; ?>
<div class="container">
    <h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['pagename']) ?></h1>
    <div class="row">
    <?php
        foreach (getItems('CatID',$_GET['pageid']) as $item) {
            echo '<div class = "col-sm-6 col-sm-3">';
            echo '<div class="thumbnail item-box">';
            echo '<span class="price-tag">' . $item['Price'] . '</span>';
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




<?php include $tpl . '/footer.php';
