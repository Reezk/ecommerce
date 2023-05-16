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
    <link rel="stylesheet" href='<?php echo $css ?>/backend.css' />
</head>

<body>
    <div class="upper-bar">
        Upperbar
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