<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}


class ISTKR_LogView
{
  public static function istkr_render_view()
  {
    require_once realpath(__DIR__) . '/../components/header.tpl.php';
    $path = ISTKR_LogController::istkr_get_debug_file_path();
?>
    <div class="container istkr-log-viewer">
      <div class="row">
        <div class="col-md-9">

          <?php if ($path && file_exists($path) && is_file($path)) { ?>
            <div class="top-section">
              <div class="log-filepath">
                Path: <span class=""><?php echo ISTKR_LogController::istkr_get_debug_file_path(); ?></span>
              </div>

              <div class="buttons">
                <button class="btn btn-primary clear-log" title="<?php _e('Clear', 'istkr'); ?>"><i class="fa fa-solid fa-trash"></i></button>
                <button class="btn btn-primary download-log" title="<?php _e('Download', 'istkr'); ?>"><i class="fa-solid fa-cloud-arrow-down"></i></button>
                <?php if (istkr()->is_premium()) { ?>
                  <button class="btn btn-success live-update" title="<?php _e('Live log updates is active', 'istkr'); ?>"><i class="fa-solid fa-tower-cell"></i></button>
                <?php } else { ?>
                  <button class="btn btn-primary refresh-log" title="<?php _e('Refresh', 'istkr'); ?>"><i class="fa fa-solid fa-arrows-rotate"></i></button>
                <?php } ?>
              </div>
            </div>
          <?php } ?>

          <?php
          if (!ISTKR_LogModel::istkr_is_log_file_exists()) {
            require_once realpath(__DIR__) . '/../components/log-missing-debug-file.tpl.php';
          } else { ?>
            <div class="table-wrapper">

              <div class="modal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                  </div>
                </div>
              </div>
              <table id="istkr_log-table" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Datetime</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Line</th>
                  </tr>
                </thead>
              </table>
            </div>
          <?php } ?>
        </div>

        <div class="col-md-3 sidebar">
          <div class="settings">
            <h5><?php _e('Settings', 'istkr') ?></h5>

            <div class="row log-viewer-row">
              <div class="log-info-block">
                <p>Debug mode</p>
                <input id="istkr_toggle_debug_mode" type="checkbox" <?php echo WP_DEBUG ? 'checked' : '' ?> name="checkbox" class="bootstrap-switch" />

              </div>
              <div class="log-info-block">
                <p>Debug scripts</p>
                <input id="istkr_toggle_debug_scripts" type="checkbox" <?php echo SCRIPT_DEBUG ? 'checked' : '' ?> name="checkbox" class="bootstrap-switch" />
              </div>

              <div class="log-info-block">
                <p>Log in file</p>
                <p class="disabled"></p>
                <input id="istkr_toggle_debug_log_scripts" type="checkbox" <?php echo WP_DEBUG_LOG ? 'checked' : '' ?> name="checkbox" class="bootstrap-switch" />
              </div>

              <div class="log-info-block">
                <p>Display errors</p>
                <input id="istkr_toggle_display_errors" type="checkbox" <?php echo WP_DEBUG_DISPLAY ? 'checked' : '' ?> name="checkbox" class="bootstrap-switch" />
              </div>
            </div>
          </div>

          <div class="notifications">
            <h5><?php _e('Notifications', 'istkr') ?></h5>
            <?php if (istkr()->is_premium()) {
              $notificator = new ISTKR_Notificator(new ISTKR_LogController());
            ?>
              <form class="form-group" id="istkr_log_viewer_notifications_form" data-notifications-enabled="<?php echo $notificator->istkr_is_notification_enabled() ? 'true' : 'false' ?>">
                <p><?php _e('You will receive an email notification in case a serious problem is detected on the website', 'istkr') ?></p>
                <p><?php _e('Monitoring tracks database, fatal, deprecated and parse errors', 'istkr') ?></p>
                <label for="email"><?php _e('Your Email:', 'istkr') ?></label>
                <input type="email" id="email" value="<?php echo $notificator->istkr_get_notification_email(); ?>">

                <label for="recurrence"><?php _e('Periodicity:', 'istkr') ?></label>
                <select name="recurrence" id="recurrence">
                  <?php echo $notificator->istkr_get_notification_recurrence(); ?>
                </select>
                <?php require_once realpath(__DIR__) . '/../components/send-test-email-checkbox.php'; ?>

                <input type="submit" value="Loading..." class="btn btn-secondary btn-sm" disabled>
              </form>
          </div>
        </div>
      <?php } else { ?>
        <p><?php _e('Upgrade to Pro plan to have the ability to get notifications from Log viewer', 'istkr'); ?></p>
        <p><?php _e('You will receive an email notification in case a serious problem is detected on the website', 'istkr') ?></p>
        <p><?php _e('Monitoring tracks database, fatal, deprecated and parse errors', 'istkr') ?></p>
        <a class="istkr-pro-features" href="<?php echo istkr()->get_upgrade_url(); ?>">
          <span><?php _e('Upgrade', 'istkr'); ?></span>
          <img src="<?php echo  plugin_dir_url(__DIR__) . '../assets/img/corona.png' ?>">
        </a>
      <?php } ?>
      </div>
    </div>
<?php
  }
}
