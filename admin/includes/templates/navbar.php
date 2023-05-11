<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapse" data-toggle='collapse' data-toggle="#app-nav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="../admin/dashboard.php" class="navbar-brand"><?php echo lang('HOME_ADMIN') ?></a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav">
                <li><a href="categories.php"><?php echo lang('CATEGORIES') ?> </a></li>
                <li><a href="items.php"><?php echo lang('ITEMS') ?> </a></li>
                <li><a href="members.php"><?php echo lang('MEMBERS') ?> </a></li>
                <li><a href="#"><?php echo lang('STATISTICS') ?> </a></li>
                <li><a href="#"><?php echo lang('LOGS') ?> </a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rezk <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('EDITE_PROFILE') ?></a></li>
                        <li><a href="#"><?php echo lang('SETTINGS') ?></a></li>
                        <li><a href="logout.php"><?php echo lang('LOGOUT') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>