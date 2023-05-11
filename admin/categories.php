<?php
/* 
===========================
=== Categories Page
===========================
*/

ob_start();
session_start();
$pageTitel = 'Categories';
if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {
        $sort = 'Asc';
        $sort_array = array('Asc', 'Desc');
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
            $sort = $_GET['sort'];
        }
        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll(); ?>

        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Manage Categories
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i> Ordering : [
                        <a class="<?php if ($sort == 'Asc') {
                                        echo 'active';
                                    } ?>" href="?sort=Asc">Asc</a> |
                        <a class="<?php if ($sort == 'Desc') {
                                        echo 'active';
                                    } ?>" href="?sort=Desc">Desc </a>]
                        <i class="fa fa-eye"></i> View : [
                        <span class="active" data-view="full">Full</span> |
                        <span data-view="classic">Classic </span>]
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    foreach ($cats as $cat) {
                        echo '<div class = "cat">';
                        echo '<div class = "hidden-buttons">';
                        echo '<a href="categories.php?do=Edit&catid=' . $cat['ID'] . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edite</a>';
                        echo '<a href="?do=Delete&catid=' . $cat['ID'] . '" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> Delete</a>';
                        echo '</div>';
                        echo '<h3>' . $cat['Name'] . '</h3>';

                        echo '<div class="full-view">'; //start full view
                        echo '<p>';
                        if ($cat['Description'] == '') {
                            echo 'This Is Description Empty';
                        } else {
                            echo $cat['Description'];
                        }
                        echo '</p>';
                        if ($cat['Visibility'] == 1) {
                            echo '<span class= "visibility"><i class="fa fa-eye"></i> Hidden </span>';
                        }
                        if ($cat['Allow_Comment'] == 1) {
                            echo '<span class= "commenting"><i class="fa fa-close"></i> Comment Disabled </span>';
                        }
                        if ($cat['Allow_Ads'] == 1) {
                            echo '<span class= "advertises"><i class="fa fa-close"></i> Ads Disabled</span>';
                        }
                        echo '</div>'; // End full view
                        echo '</div>';
                        echo '<hr>';
                    }
                    ?>
                </div>
            </div>
            <a class="add-category btn btn-primary" href="?do=Add"><i class="fa fa-plus"></i> New Category</a>
        </div>
    <?php
    } elseif ($do == 'Add') {
    ?>
        <h1 class="text-center">Add New Categories</h1>
        <div class="container">
            <form action="?do=Insert" method="POST" class="form-horizontal">
                <!-- Start Name Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name Of The Categories" required='required'>
                    </div>
                </div>
                <!-- End Name Filed -->
                <!-- Start Description Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Describe The Categories">
                    </div>
                </div>
                <!-- End Description Filed -->
                <!-- Start Odrering Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Odrering</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="texe" name="ordering" class="form-control" placeholder="Number To Arrange The Categories">
                    </div>
                </div>
                <!-- End Odrering Filed -->
                <!-- Start Visible Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Visible</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" checked>
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1">
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Visible Filed -->
                <!-- Start Commenting Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked>
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1">
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Commenting Filed -->
                <!-- Start Ads Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked>
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1">
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Ads Filed -->
                <!-- Start button  Filed -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        <input type="submit" value="Add Category" class="btn btn-primary">
                    </div>
                </div>
                <!-- End button  Filed -->
            </form>
        </div>
    <?php
    } elseif ($do == 'Insert') {
        echo "<div class = 'container'>";
        echo "<h1 class = 'text-center'>Insert Categories</h1>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $name = $_POST['name'];
            $description = $_POST['description'];
            $ordering = $_POST['ordering'];
            $visibility = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];


            // check if Categories exist in database

            $chek = checkItem('Name', 'categories', $name);
            if ($chek == 1) {
                $thMsg = "<div class='alert alert-danger text-center'>Sorry This Categories Is Exist</div>";
                redirectHome($thMsg, 'back', 50);
            } else {
                // Insert Categories Info In Database
                $stmt = $con->prepare("INSERT INTO 
                categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads)
                VALUES(:zname,:zdesc,:zorder,:zvis,:zcomm,:zads)");
                $stmt->execute(array(
                    'zname' => $name,
                    'zdesc' => $description,
                    'zorder' => $ordering,
                    'zvis' => $visibility,
                    'zcomm' => $comment,
                    'zads' => $ads
                ));
                echo '<div class = "container">';
                $successMsg = '<div class="alert alert-success text-center"> ' . $stmt->rowCount() . ' Record Insert' . '</div>';
                redirectHome($successMsg, 'categories.php');
                echo '</div>';
            }
        } else {
            $errorMsg =  '<div class="alert alert-danger text-center"> You Cant Browser The Pge Directly</div>';
            redirectHome($errorMsg, 6);
        }
        echo '</div>';
    } elseif ($do == 'Edit') {
        //Check If Get Request catid Is Numeric & Get Integet Value
        $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
    ?>

        <h1 class="text-center">Edit New Categories</h1>
        <div class="container">
            <?php if ($stmt->rowCount() > 0) { ?>
                <form action="?do=Update" method="POST" class="form-horizontal">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>">
                    <!-- Start Name Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $cat['Name'] ?>" placeholder="Name Of The Categories" required='required'>
                        </div>
                    </div>
                    <!-- End Name Filed -->
                    <!-- Start Description Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class="form-control" value="<?php echo $cat['Description'] ?>" placeholder="Describe The Categories">
                        </div>
                    </div>
                    <!-- End Description Filed -->
                    <!-- Start Odrering Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="texe" name="ordering" class="form-control" value="<?php echo $cat['Ordering'] ?>" placeholder="Number To Arrange The Categories">
                        </div>
                    </div>
                    <!-- End Odrering Filed -->
                    <!-- Start Visible Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0) {
                                                                                                    echo 'checked';
                                                                                                } ?>>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1) {
                                                                                                echo 'checked';
                                                                                            } ?>>
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Visible Filed -->
                    <!-- Start Commenting Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) {
                                                                                                    echo 'checked';
                                                                                                } ?>>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) {
                                                                                                echo 'checked';
                                                                                            } ?>>
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Commenting Filed -->
                    <!-- Start Ads Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads Filed -->
                    <!-- Start button  Filed -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 ">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- End button  Filed -->
                </form>
        </div>

<?php
            } else {
                $errorMsg = '<div class="alert alert-danger text-center"> There Is No such ID</div>';
                redirectHome($errorMsg,  6);
            }
        } elseif ($do == 'Update') {
            echo "<h1 class = 'text-center'>Update Category</h1>";
            echo "<div class = 'container'>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['catid'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $ordering = $_POST['ordering'];
                $visibility = $_POST['visibility'];
                $commenting = $_POST['commenting'];
                $ads = $_POST['ads'];

                $stmt = $con->prepare("UPDATE 
                                            `categories` 
                                        SET 
                                                    `Name` =? , 
                                                    `Description` = ?, 
                                                    Ordering =?,
                                                    Visibility =?,
                                                    Allow_Comment =?,
                                                    Allow_Ads =?
                                                        WHERE 
                                                    ID = ?");
                $stmt->execute(array(
                    $name,
                    $description,
                    $ordering,
                    $visibility,
                    $commenting,
                    $ads,
                    $id
                ));

                $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Update</div>';
                redirectHome($successMsg,  50);
            } else {
                $errorMsg =  '<div class="alert alert-danger text-center">You Cant Browser The Pge Directly</div>';
                redirectHome($errorMsg,  3);
            }
            echo "</div>";
        } elseif ($do == 'Delete') {
            echo "<h1 class = 'text-center'>Delete Category</h1>";
            echo "<div class = 'container'>";
            //Check If Get Request catid Is Numeric & Get The Integer Value Of It
            $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;
            $chek = checkItem('ID', 'categories', $catid);

            if ($chek > 0) {
                $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zcatid");
                $stmt->bindParam(":zcatid", $catid);
                $stmt->execute();
                $successMsg =  '<div class="alert alert-success text-center">' . $stmt->rowCount() . ' Record Deleted</div>';
                redirectHome($successMsg,  6);
            } else {
                $errorMsg = '<div class="alert alert-danger text-center"> The ID Is not Exist</div>';;
                redirectHome($errorMsg,  'back');
            }
            echo "</div>";
        }
        include $tpl . 'footer.php';
    } else {
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
