<?php

if (!defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}

class ISTKR_HooksController
{
    public static function istkr_init()
    {
        $istkr_index_file = plugin_dir_path(__DIR__) . 'index.php';
        $log_controller = new ISTKR_LogController();

        // Include styles and scripts in Issues Tracker plugin's pages only
        add_action('admin_enqueue_scripts',                               ['ISTKR_HooksController', 'istkr_admin_assets_enqueue']);
        register_activation_hook($istkr_index_file,                       ['ISTKR_HooksController', 'istkr_activate']);
        register_deactivation_hook($istkr_index_file,                     ['ISTKR_ServiceController', 'istkr_deactivation_events']);
        register_uninstall_hook($istkr_index_file,                        ['ISTKR_ServiceController', 'istkr_uninstall_events']);
        add_action('wp_ajax_istkr_get_log_data',                          ['ISTKR_LogController', 'istkr_get_log_data']);
        add_action('wp_ajax_istkr_get_log_stat',                          ['ISTKR_LogController', 'istkr_get_log_stat']);
        // Advisor
        add_action('wp_ajax_istkr_run_check',                             ['ISTKR_AdvisorController', 'istkr_run_check']);
        add_action('wp_ajax_istkr_change_advisor_notifications_status',   ['ISTKR_AdvisorController', 'istkr_change_notifications_status']);

        // Log viewer
        add_action('wp_ajax_istkr_log_viewer_clear_log',                   ['ISTKR_LogController', 'istkr_clear_log']);
        add_action('wp_ajax_istkr_log_viewer_download_log',                ['ISTKR_LogController', 'istkr_download_log']);
        add_action('wp_ajax_istkr_change_log_viewer_notifications_status', ['ISTKR_LogController', 'istkr_change_log_notifications_status']);
        add_action('wp_ajax_istkr_log_viewer_live_update',                 ['ISTKR_LogController', 'istkr_live_update']);

        add_action('wp_ajax_istkr_log_viewer_enable_logging', function () use ($log_controller) {
            $log_controller->istkr_log_viewer_enable_logging();
        });

        add_action('wp_ajax_istkr_toggle_debug_mode', function () use ($log_controller) {
            $log_controller->istkr_toggle_debug_mode();
        });
        add_action('wp_ajax_istkr_toggle_debug_scripts', function () use ($log_controller) {
            $log_controller->istkr_toggle_debug_scripts();
        });
        add_action('wp_ajax_istkr_toggle_debug_log_scripts',  function () use ($log_controller) {
            $log_controller->istkr_toggle_debug_log_scripts();
        });
        add_action('wp_ajax_istkr_toggle_display_errors',  function () use ($log_controller) {
            $log_controller->istkr_toggle_display_errors();
        });

        // 404
        // catch and record in database 404 path
        add_action('template_redirect',                                  ['ISTKR_HooksController', 'istkr_template_redirect']);
        add_action('wp_ajax_istkr_get_404_log',                          ['ISTKR_404Controller', 'istkr_get_404_log']);
        add_action('wp_ajax_istkr_change_404_notifications_status',      ['ISTKR_404Controller', 'istkr_change_notifications_status']);
        add_action('wp_ajax_istkr_get_current_user_email',               ['ISTKR_404Controller', 'istkr_get_current_user_email']);
        add_action('wp_ajax_istkr_get_404_count',                        ['ISTKR_404Controller', 'istkr_get_404_count']);
        // buttons action
        add_action('wp_ajax_istkr_404_clear_log',                        ['ISTKR_404Controller', 'istkr_404_clear_log']);
        add_action('wp_ajax_istkr_404_recheck_path',                     ['ISTKR_404Controller', 'istkr_404_recheck_path']);
        add_action('wp_ajax_istkr_404_remove_path',                      ['ISTKR_404Controller', 'istkr_404_remove_path']);

        add_action(ISTKR_AdvisorController::SCHEDULE_MAIL_SEND,          ['ISTKR_AdvisorController', 'istkr_advisor_checks_handler'], 10, 1);
        add_action(ISTKR_404Controller::SCHEDULE_MAIL_SEND,              ['ISTKR_404Controller', 'istkr_send_404_log_handler'], 10, 1);
        add_action(ISTKR_LogController::SCHEDULE_MAIL_SEND,              ['ISTKR_LogController', 'istkr_send_logs_handler'], 10, 1);

        add_action('admin_init', function () {
            if (ISTKR_ReviewController::istkr_is_review_delaying_expired()) {
                add_action('admin_notices', ['ISTKR_ReviewController', 'istkr_ask_to_leave_review_handler']);
            }
        });
        add_action('admin_init', ['ISTKR_ReviewController', 'istkr_review_handler']);
    }

    public static function istkr_activate()
    {
        ISTKR_ServiceController::istkr_activation_events();
        ISTKR_Migrations::istkr_migrate();
    }

    public static function istkr_template_redirect()
    {
        ISTKR_404Controller::istkr_handle_404();
    }

    public static function istkr_admin_assets_enqueue($hook_suffix)
    {
        // echo $hook_suffix;
        // Include styles and scripts in Issues Tracker plugin pages only

        if (
            strpos($hook_suffix, 'issues-tracker_page_issues-tracker-log-viewer') !== false ||
            strpos($hook_suffix, 'toplevel_page_issues-tracker-dashboard') !== false ||
            strpos($hook_suffix, 'issues-tracker_page_issues-tracker-advisor') !== false ||
            strpos($hook_suffix, 'issues-tracker_page_issues-tracker-404') !== false ||
            strpos($hook_suffix, 'issues-tracker_page_issues-tracker-server-info') !== false
        ) {

            if (!ISTKR_ServiceController::istkr_is_dev()) {
                add_action( 'admin_head', ['ISTKR_ServiceController', 'istkr_init_gtm']);
            }

            wp_enqueue_script('istkr_toast_js',                  plugins_url('assets/vendor/js/toast.js', __DIR__), array('jquery'));
            wp_enqueue_script('istkr_bootstrap_js',              plugins_url('assets/vendor/js/bootstrap.bundle.min.js', __DIR__));
            wp_enqueue_script('istkr_bootstrap_switch_js',       plugins_url('assets/vendor/js/bootstrap-switch.min.js', __DIR__, array('jquery')));
            wp_enqueue_script('istkr_datatables_js',             plugins_url('assets/vendor/js/jquery.dataTables.min.js', __DIR__), array('jquery'));
            wp_enqueue_script('istkr_app_js',                    plugins_url('assets/js/app.js', __DIR__), array('jquery'));
            wp_enqueue_script('istkr_font-awesome_js',           plugins_url('assets/vendor/js/font-awesome.js', __DIR__));
            wp_enqueue_script('istkr_ua-parser_js',              plugins_url('assets/vendor/js/ua-parser.min.js', __DIR__));
            // DataTables buttons
            wp_enqueue_script('istkr_datatables_buttons_js',     plugins_url('assets/vendor/js/dataTables.buttons.min.js', __DIR__));
            wp_enqueue_script('istkr_zip_js',                    plugins_url('assets/vendor/js/jszip.min.js', __DIR__));
            wp_enqueue_script('istkr_buttons_html5_js',          plugins_url('assets/vendor/js/buttons.html5.min.js', __DIR__));
            wp_enqueue_script('istkr_buttons_print_js',          plugins_url('assets/vendor/js/buttons.print.min.js', __DIR__));
            wp_enqueue_script('istkr_buttons_colvis_js',         plugins_url('assets/vendor/js/buttons.colVis.min.js', __DIR__));

            wp_localize_script('istkr_app_js', 'istkr_backend_data', [
                'is_dev'       => ISTKR_ServiceController::istkr_is_dev(),
                'anatylics_id' => ISTKR_Constants::$GA_ID,
                'is_premium'   => istkr()->is_premium(),
                'ajax_nonce'   => wp_create_nonce('ajax_nonce'),
            ]);
            wp_enqueue_style('istkr_bootstrap_css',              plugins_url('assets/vendor/css/bootstrap.min.css', __DIR__));
            wp_enqueue_style('istkr_toast_css   ',               plugins_url('assets/vendor/css/toast.css', __DIR__));
            wp_enqueue_style('istkr_now-ui_css',                 plugins_url('assets/vendor/css/now-ui-kit.min.css', __DIR__), ['istkr_bootstrap_css']);
            wp_enqueue_style('istkr_datatables_css',             plugins_url('assets/vendor/css/jquery.dataTables.min.css', __DIR__));
            wp_enqueue_style('istkr_datatables_buttons_css',     plugins_url('assets/vendor/css/buttons.dataTables.min.css', __DIR__));
            wp_enqueue_style('istkr_style',                      plugins_url('assets/css/style.css', __DIR__));
        }
    }
}
