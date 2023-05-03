<?php
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


if ($do == 'Manage') {
    echo 'Welcome to Manage';
    echo '<a href="?do=Add">Add New Category</a>';
} elseif ($do == 'Add') {
    echo 'Welcome to Add';
} elseif ($do == 'Insert') {
    echo 'Welcome to Insert';
} else {
    echo 'Error ther\'s No Page With This Name';
};
