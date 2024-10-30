<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class ISTKR_DashboardView
{

    public static function istkr_render_view()
    {
    ?>
        <?php
            if (!is_writable(ISTKR_Constants::get_wp_config_path())) {
                require_once realpath(__DIR__) . '/../components/log-wp-config-not-writable.tpl.php';
                return;
            }

            require_once realpath(__DIR__) . '/../components/header.tpl.php';
        ?>
         <div class="container istkr-dashboard">
            <div class="row">
                <div class="col-md-4">
                    <div class="card module-card log">
                        <div class="card-body">
                            <div class="card-title">
                                <h4><a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-log-viewer">Log viewer</a></h4>
                                <p class="info"> Changed at: <span class="count">N/A</span></p>
                                <?php if (istkr()->is_premium()) { ?>
                                    <div class="notification-status">
                                        <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-log-viewer" title="Click to go to the notification form">
                                            <?php
                                            $instance = new ISTKR_LogController();
                                            $notificator = new ISTKR_Notificator($instance);

                                            if ($notificator->istkr_is_notification_enabled()) { ?>
                                                <i class="fa-regular fa-bell"></i>
                                            <?php } else { ?>
                                                <i class="fa-regular fa-bell-slash"></i>
                                            <?php } ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>

                            <p class="card-text">Access the log file to search for errors by type, line, and file. Additionally, view the current status of the debug mode</p>

                            <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-log-viewer" class="btn btn-sm btn-info">Open</a>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card module-card advisor">
                        <div class="card-body">
                            <div class="card-title">
                                <h4><a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-advisor">Advisor</a></h4>
                                <div class="info d-flex">
                                    <p class="me-3">Passed: <span class="count">N/A</span></p>
                                    <p class="me-3">Failed: <span class="count">N/A</span></p>
                                </div>

                                <?php if (istkr()->is_premium()) { ?>
                                    <div class="notification-status">
                                        <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-advisor" title="Click to go to the notification form">
                                            <?php
                                            $instance = new ISTKR_AdvisorController();
                                            $notificator = new ISTKR_Notificator($instance);

                                            if ($notificator->istkr_is_notification_enabled()) { ?>
                                                <i class="fa-regular fa-bell"></i>
                                            <?php } else { ?>
                                                <i class="fa-regular fa-bell-slash"></i>
                                            <?php } ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>

                            <p class="card-text">This audit is designed to identify security issues that may be affecting the website's safety and integrity</p>

                            <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-advisor" class="btn btn-sm btn-info">Open</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card module-card 404">
                        <div class="card-body">
                            <div class="card-title">
                                <h4><a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-404">404</a></h4>
                                <p class="info">Catched 404: <span class="count">N/A</span></p>

                                <?php if (istkr()->is_premium()) { ?>
                                    <div class="notification-status">
                                        <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-404" title="Click to go to the notification form">
                                            <?php
                                            $instance = new ISTKR_404Controller();
                                            $notificator = new ISTKR_Notificator($instance);

                                            if ($notificator->istkr_is_notification_enabled()) { ?>
                                                <i class="fa-regular fa-bell"></i>
                                            <?php } else { ?>
                                                <i class="fa-regular fa-bell-slash"></i>
                                            <?php } ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>

                            <p class="card-text">This component showcases 404 URLs captured on the website and allows you to configure notifications when a 404 is detected</p>

                            <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-404" class="btn btn-sm btn-info">Open</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card module-card server-info" style="max-width: 520px">
                        <div class="card-body">
                            <div class="card-title">
                                <h4 class="card-title"><a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-server-info">Server info</a></h4>
                            </div>
                            <p class="card-text">Access all your server configuration settings conveniently on a single page</p>


                            <a href="<?php echo admin_url(); ?>admin.php?page=issues-tracker-server-info" class="btn btn-sm btn-info">Open</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php

    }
}
