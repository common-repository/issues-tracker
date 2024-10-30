<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class ISTKR_MenuController
{
    public static function istkr_init()
    {
        add_action('admin_menu', 'istkr_main_menu', 9, 0);

        function istkr_main_menu()
        {

            $role = 'edit_pages';
            add_menu_page(__('Dashboard', 'istkr'), __('Issues tracker', 'istkr'), $role, 'issues-tracker-dashboard', ['ISTKR_DashboardController', 'istkr_render_view'], plugin_dir_url(__FILE__) . '/../../assets/img/logo.svg');

            add_submenu_page('issues-tracker-dashboard', __('Issues tracker dashboard', 'istkr'), __('Dashboard', 'istkr'), $role, 'issues-tracker-dashboard', ['ISTKR_DashboardController', 'istkr_render_view']);

            add_submenu_page('issues-tracker-dashboard', __('Debug log viewer', 'istkr'), __('Log viewer', 'istkr'), $role, 'issues-tracker-log-viewer',  ['ISTKR_LogController', 'istkr_render_view']);

            add_submenu_page('issues-tracker-dashboard', __('Security advisor', 'istkr'), __('Advisor', 'istkr'), $role, 'issues-tracker-advisor',  ['ISTKR_AdvisorController', 'istkr_render_view']);

            add_submenu_page('issues-tracker-dashboard', __('404 logger', 'istkr'), __('404', 'istkr'), $role, 'issues-tracker-404',  ['ISTKR_404Controller', 'istkr_render_view']);

            add_submenu_page('issues-tracker-dashboard', __('Server info', 'istkr'), __('Server info', 'istkr'), $role, 'issues-tracker-server-info',  ['ISTKR_ServerInfoController', 'istkr_render_view']);
     
        }
    }
}
