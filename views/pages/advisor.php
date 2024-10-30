<?php

if (!defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}

class ISTKR_AdvisorView
{
    public static function istkr_render_view()
    {
        if (!is_writable(ISTKR_Constants::get_wp_config_path())) {
            require_once realpath(__DIR__) . '/../components/log-wp-config-not-writable.tpl.php';
            return;
        }

        require_once realpath(__DIR__) . '/../components/header.tpl.php';
?>
        <div class="container istkr-advisor">
            <div class="row">
                <div class="col-md-9">
                    <div class="top-section">
                        <div class="istkr-advisor-progress-bar">
                            <div class="progress-bar success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar fail" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="istkr-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" id="istkr_advice_database_username">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_database_username_body" aria-expanded="false" aria-controls="#istkr_advice_database_username_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_database_username')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </div>
                            <div id="istkr_advice_database_username_body" class="accordion-collapse collapse" aria-labelledby="istkr_advice_database_username" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_database_password">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_database_password_body" aria-expanded="false" aria-controls="#istkr_advice_database_password_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_database_password')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_database_password_body" class="accordion-collapse collapse" aria-labelledby="istkr_advice_database_password" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_users_with_popular_logins">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_users_with_popular_logins_body" aria-expanded="false" aria-controls="istkr_users_with_popular_logins_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_users_with_popular_logins')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_users_with_popular_logins_body" class="accordion-collapse collapse" aria-labelledby="istkr_users_with_popular_logins" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_free_disk_space">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_free_disk_space_body" aria-expanded="false" aria-controls="istkr_advice_free_disk_space_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_free_disk_space')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_free_disk_space_body" class="accordion-collapse collapse" aria-labelledby="istkr_advice_free_disk_space" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_is_display_errors_enabled">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_is_display_errors_enabled_body" aria-expanded="false" aria-controls="istkr_is_display_errors_enabled_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_is_display_errors_enabled')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_is_display_errors_enabled_body" class="accordion-collapse collapse" aria-labelledby="istkr_is_display_errors_enabled" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_database_prefix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_database_prefix_body" aria-expanded="false" aria-controls="istkr_advice_database_prefix_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_database_prefix')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_database_prefix_body" class="accordion-collapse collapse" aria-labelledby="istkr_advice_database_prefix" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_is_ssl_enabled">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_is_ssl_enabled_body" aria-expanded="false" aria-controls="istkr_is_ssl_enabled">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_is_ssl_enabled')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_is_ssl_enabled_body" class="accordion-collapse collapse" aria-labelledby="istkr_is_ssl_enabled" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_search_visibility">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_search_visibility_body" aria-expanded="false" aria-controls="istkr_is_wp_ver_displayed_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            $postfix = ISTKR_AdvisorModel::istkr_is_localhost() ? 'local' : 'prod';
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_search_visibility_' . $postfix)['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_search_visibility_body" class="accordion-collapse collapse" aria-labelledby="istkr_is_wp_ver_displayed" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_outdated_php">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_outdated_php_body" aria-expanded="false" aria-controls="istkr_advice_outdated_php">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_outdated_php')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_outdated_php_body" class="accordion-collapse collapse" aria-labelledby="istkr_advice_outdated_php" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="istkr_advice_is_wp_ver_displayed">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#istkr_advice_is_wp_ver_displayed_body" aria-expanded="false" aria-controls="istkr_is_wp_ver_displayed_body">
                                    <div class="header-data">
                                        <div class="status-badge unknown">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </div>
                                        <span class="check-title">
                                            <?php
                                            echo  ISTKR_AdvisorModel::istkr_get_check_details_by_name('istkr_advice_is_wp_ver_displayed')['title'];
                                            ?>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="istkr_advice_is_wp_ver_displayed_body" class="accordion-collapse collapse" aria-labelledby="istkr_is_wp_ver_displayed" data-bs-parent="#istkr-accordion-1">
                                <div class="accordion-body"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 sidebar">
                    <div class="notifications">
                        <h5><?php _e('Notifications', 'istkr') ?></h5>
                        <?php if (istkr()->is_premium()) {
                            $notificator = new ISTKR_Notificator(new ISTKR_AdvisorController());
                        ?>

                            <form class="form-group" id="istkr_advisor_notifications_form" data-notifications-enabled="<?php echo $notificator->istkr_is_notification_enabled() ? 'true' : 'false' ?>">
                                <p>You will receive an email notification at the selected interval about detected problems on the website</p>
                                <p>Pay attention: notification will be send if status of checks changes from "Passed" to "Failed"</p>

                                <label for="email"><?php _e('Your Email:', 'istkr') ?></label>
                                <input type="email" id="email" value="<?php echo $notificator->istkr_get_notification_email(); ?>" style="width:100%; margin-top: 10px">

                                <label for="recurrence"><?php _e('Periodicity:', 'istkr') ?></label>
                                <select name="recurrence" id="recurrence" style="width: 100%; margin-top: 10px">
                                    <?php echo $notificator->istkr_get_notification_recurrence(); ?>
                                </select>
                                <?php require_once realpath(__DIR__) . '/../components/send-test-email-checkbox.php'; ?>

                                <input type="submit" value="Loading..." class="btn btn-secondary btn-sm" disabled>
                            </form>

                        <?php

                        } else { ?>
                            <p><?php _e('Upgrade to Pro plan to have the ability to get notifications when Advisor detects changes in website state', 'istkr'); ?></p>

                            <a class="istkr-pro-features" href="<?php echo istkr()->get_upgrade_url(); ?>">
                                <span><?php _e('Upgrade', 'istkr'); ?></span>
                                <img src="<?php echo  plugin_dir_url(__DIR__) . '../assets/img/corona.png' ?>">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
