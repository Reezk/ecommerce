<?php
/* 
===========================
=== Items Page
===========================
*/

ob_start();
session_start();
$pageTitel = 'Items';
if (isset($_SESSION['Username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {

        $stmt = $con->prepare("SELECT items.*, categories.Name AS categoru_name,users.Username AS user_name
        FROM items 
        INNER JOIN categories ON categories.ID = items.CatID
        INNER JOIN users ON users.UserID = items.MemberID");
        $stmt->execute();
        $items = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="tabel-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Data</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>
                    </tr>
                    <?php foreach ($items as  $item) {
                        echo '
                        <tr>
                            <td>' . $item['ItemID'] . '</td>
                            <td>' . $item['Name'] . '</td>
                            <td>' . $item['Description'] . '</td>
                            <td>' . $item['Price'] . '</td>
                            <td>' . $item['AddDate'] . '</td>
                            <td>' . $item['categoru_name'] . '</td>
                            <td>' . $item['user_name'] . '</td>
                            <td>
                                <a class="btn btn-success" href="items.php?do=Edit&itemid=' . $item['ItemID'] . '"><i class ="fa fa-edit"></i> Edit</a>
                                <a class="btn btn-danger confirm" href="items.php?do=Delete&itemid=' . $item['ItemID'] . '"><i class ="fa fa-close"></i> Delete</a>';
                        echo '</td>
                        </tr>
                        ';
                    } ?>
                </table>
            </div>
            <a class="btn btn-sm btn-success" href="items.php?do=Add"><i class="fa fa-plus"></i> New Item</a>
        </div>
    <?php
    } elseif ($do == 'Add') {
    ?>
        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form action="?do=Insert" method="POST" class="form-horizontal">
                <!-- Start Name Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Name Of The Item">
                    </div>
                </div>
                <!-- End Name Filed -->
                <!-- Start Description Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Describe The Item">
                    </div>
                </div>
                <!-- End Description Filed -->
                <!-- Start Price Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" placeholder="Price Of The Item">
                    </div>
                </div>
                <!-- End Price Filed -->
                <!-- Start Contry Made Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Contry Made</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="contry" class="form-control" placeholder="Contry Made Of The Item">
                    </div>
                </div>
                <!-- End Contry Made Filed -->
                <!-- Start Status Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="" name="status" id="">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
                </div>
                <!-- End Status Filed -->
                <!-- Start Rating Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Rating</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="" name="rating" id="">
                            <option value="0">...</option>
                            <option value="1">1 | *</option>
                            <option value="2">2 | **</option>
                            <option value="3">3 | ***</option>
                            <option value="4">4 | ****</option>
                            <option value="5">5 | *****</option>
                        </select>
                    </div>
                </div>
                <!-- End Rating Filed -->
                <!-- Start Members Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Members</label>
                    <div class="col-sm-10 col-md-6">
                        <select class="" name="members" id="">
                            <option value="0">...</option>
                            <?php

                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user) {
                                echo '<option value="' . $user['UserID'] . '">' . $user['Username'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- End Members Filed -->
                <!-- Start Categories Filed -->
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Categories</label>
                    <div class="col-sm-10 col-md-6">
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
    <?php
    } elseif ($do == 'Insert') {
        echo "<div class = 'container'>";
        echo "<h1 class = 'text-center'>Insert Categories</h1>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $contry = $_POST['contry'];
            $status = $_POST['status'];
            $rating = $_POST['rating'];
            $members = $_POST['members'];
            $categories = $_POST['categories'];
            //Validate The Form
            $formErrors = array();
            if (empty($name)) {
                $formErrors[] = 'Name cant be <strong>Empty</strong>';
            }
            if (empty($description)) {
                $formErrors[] = 'Description cant be <strong>Empty</strong>';
            }
            if (empty($price)) {
                $formErrors[] = 'Price  cant be <strong>Empty</strong>';
            }
            if ($status == 0) {
                $formErrors[] = 'You Must Choose the <strong>Status</strong>';
            }
            if ($rating == 0) {
                $formErrors[] = 'You Must Choose the <strong>rating</strong>';
            }
            if (empty($contry)) {
                $formErrors[] = 'Contry cant be <strong>Empty</strong>';
            }
            if ($categories == 0) {
                $formErrors[] = 'You Must Choose the <strong>Categories</strong>';
            }
            if ($members == 0) {
                $formErrors[] = 'You Must Choose the <strong>Members</strong>';
            }
            foreach ($formErrors as $error) {
                echo '<div class ="alert alert-danger text-center" >' . $error . '</div>';
            }
            // check if Categories exist in database

            if (empty($formErrors)) {
                // check if user exist in database
                $chek = checkItem('Name', 'items', $name);
                if ($chek == 1) {
                    $thMsg = "<div class='alert alert-danger text-center'>Sorry This Categories Is Exist</div>";
                    redirectHome($thMsg, 'back', 50);
                } else {
                    // Insert Item Info In Database
                    $stmt = $con->prepare("INSERT INTO items(Name,Description,Price,CountryMade,Status,Rating,AddDate,MemberID,CatID)
                    VALUES(:zname,:zdesc,:zprice,:zmade,:zstatus,:zrating,now(),:zmemberid,:zcatid)");
                    $stmt->execute(array(

                        'zname' => $name,
                        'zdesc' => $description,
                        'zprice' => $price,
                        'zmade' => $contry,
                        'zstatus' => $status,
                        'zrating' => $rating,
                        'zmemberid' => $members,
                        'zcatid' => $categories

                    ));
                    echo '<div class = "container">';
                    $successMsg = '<div class="alert alert-success text-center"> ' . $stmt->rowCount() . ' Record Insert' . '</div>';
                    redirectHome($successMsg, 'items.php');
                    echo '</div>';
                }
            }
        } else {
            $errorMsg =  '<div class="alert alert-danger text-center"> You Cant Browser The Pge Directly</div>';
            redirectHome($errorMsg, 6);
        }
        echo '</div>';
    } elseif ($do == 'Edit') {
        //chick if get request itemid  is numeric & get its integer   value
        $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;
        $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
        $stmt->execute(array($itemid));
        $item    = $stmt->fetch();
        $count = $stmt->rowCount();

    ?>
        <h1 class="text-center">Edit Item</h1>
        <div class="container">
            <?php if ($count > 0) { ?>
                <form action="?do=Update" method="POST" class="form-horizontal">
                    <!-- Start Name Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $item['Name']  ?>" placeholder="Name Of The Item" required="required">
                        </div>
                    </div>
                    <!-- End Name Filed -->
                    <!-- Start Description Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class="form-control" value="<?php echo $item['Description']  ?>" placeholder="Describe The Item">
                        </div>
                    </div>
                    <!-- End Description Filed -->
                    <!-- Start Price Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" class="form-control" value="<?php echo $item['Price']  ?>" placeholder="Price Of The Item">
                        </div>
                    </div>
                    <!-- End Price Filed -->
                    <!-- Start Contry Made Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Contry Made</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="contry" class="form-control" value="<?php echo $item['CountryMade']  ?>" placeholder="Contry Made Of The Item">
                        </div>
                    </div>
                    <!-- End Contry Made Filed -->
                    <!-- Start Status Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="" name="status" id="">
                                <option value="1" <?php if ($item['Status'] == 1) {
                                                        echo 'selected';
                                                    }  ?>>New</option>
                                <option value="2" <?php if ($item['Status'] == 2) {
                                                        echo 'selected';
                                                    }  ?>>Like New</option>
                                <option value="3" <?php if ($item['Status'] == 3) {
                                                        echo 'selected';
                                                    }  ?>>Used</option>
                                <option value="4" <?php if ($item['Status'] == 4) {
                                                        echo 'selected';
                                                    }  ?>>Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Filed -->
                    <!-- Start Rating Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Rating</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="" name="rating" id="">
                                <option value="1" <?php if ($item['Rating'] == 1) {
                                                        echo 'selected';
                                                    }  ?>>1 | *</option>
                                <option value="2" <?php if ($item['Rating'] == 2) {
                                                        echo 'selected';
                                                    }  ?>>2 | **</option>
                                <option value="3" <?php if ($item['Rating'] == 3) {
                                                        echo 'selected';
                                                    }  ?>>3 | ***</option>
                                <option value="4" <?php if ($item['Rating'] == 4) {
                                                        echo 'selected';
                                                    }  ?>>4 | ****</option>
                                <option value="5" <?php if ($item['Rating'] == 5) {
                                                        echo 'selected';
                                                    }  ?>>5 | *****</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Rating Filed -->
                    <!-- Start Members Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Members</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="" name="members" id="">
                                <?php

                                $stmt = $con->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user) {
                                    echo "<option value='" . $user['UserID'] . "'";
                                    if ($item['MemberID'] == $user['UserID']) {
                                        echo 'selected';
                                    }
                                    echo ">" . $user['Username'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Members Filed -->
                    <!-- Start Categories Filed -->
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Categories</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="" name="categories" id="">
                                <?php

                                $stmt2 = $con->prepare("SELECT * FROM categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                foreach ($cats as $cat) {
                                    echo "<option value='" . $cat['ID'] . "'";
                                    if ($item['CatID'] == $cat['ID']) {
                                        echo "selected";
                                    }

                                    echo ">" . $cat['Name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Members Filed -->
                    <!-- Start button  Filed -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 ">
                            <input type="submit" value="Save Item" class="btn btn-primary btn-sm">
                        </div>
                    </div>
                    <!-- End button  Filed -->
                </form>
        </div>
<?php
            }
        } elseif ($do == 'Update') {
        } elseif ($do == 'Delete') {
        } elseif ($do == 'Approve') {
        }
        include $tpl . 'footer.php';
    } else {
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
