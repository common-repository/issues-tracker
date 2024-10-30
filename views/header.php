<div id="istkr_notify" style="position: fixed; z-index:999; width: 100%"></div>
<nav class="navbar navbar-expand-lg bg-info">

    <div class="container-fluid">
        <div class="navbar-translate">
            <a class="navbar-brand" href="<?php echo admin_url(); ?>/admin.php?page=issues-tracker-dashboard">
                <img src="<?php echo plugins_url('assets/img/dash-logo.svg', __DIR__); ?>" alt="" width="45" height="34" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#istkr-navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="istkr-navbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-log-viewer">Log viewer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-advisor">Advisor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-404">404</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo  admin_url(); ?>admin.php?page=issues-tracker-server-info">
                        <p><?php _e('Server info', 'istrk');?></p>
                    </a>
                </li>
            </ul>
        </div>
        <?php
        if (istkr()->is_premium()) { ?>
            <a class="istkr-pro-features" href="<?php echo istkr()->get_upgrade_url(); ?>">
                <span><?php _e('You\'re Pro', 'istkr'); ?></span>
                <img src="<?php echo  plugin_dir_url(__DIR__) . 'assets/img/corona.png' ?>">
            </a>
        <?php } else { ?>
            <a class="istkr-pro-features" href="<?php echo istkr()->get_upgrade_url(); ?>">
                <span><?php _e('Get pro features', 'istkr'); ?></span>
                <img src="<?php echo  plugin_dir_url(__DIR__) . 'assets/img/corona.png' ?>">
            </a>
        <?php } ?>
    </div>
</nav>
