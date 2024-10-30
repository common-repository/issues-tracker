<?php

/**
 * Plugin Name: Issues Tracker
 * Description: Issues Tracker helps monitor WordPress logs, track 404 errors, view server settings, and receive security advice, all in one dashboard
 * Author: lysyiweb
 * Version: 1.15
 * Tags: debug, logging, WP_DEBUG, security, error-tracking
 * Requires PHP: 5.4
 * Tested up to: 6.6.2
 * Stable tag: 1.15
 * Plugin URI: https://issues-tracker.top/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !function_exists( 'istkr' ) ) {
    // Create a helper function for easy SDK access.
    function istkr() {
        global $istkr;
        if ( !isset( $istkr ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/wordpress-sdk/start.php';
            $istkr = fs_dynamic_init( array(
                'id'             => '8570',
                'slug'           => 'issues-tracker',
                'premium_slug'   => 'issues-tracker-pro',
                'type'           => 'plugin',
                'public_key'     => 'pk_b8add8da26b8c97775aaf7e1c4ab7',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                    'slug'       => 'issues-tracker-dashboard',
                    'first-path' => 'admin.php?page=issues-tracker-dashboard',
                ),
                'is_live'        => true,
            ) );
        }
        return $istkr;
    }

    // Init Freemius.
    istkr();
    // Signal that SDK was initiated.
    do_action( 'istkr_loaded' );
}
require_once realpath( __DIR__ ) . '/helpers/security.php';
require_once realpath( __DIR__ ) . '/helpers/constants.php';
require_once realpath( __DIR__ ) . '/migrations/Migrations.php';
require_once realpath( __DIR__ ) . '/controllers/HooksController.php';
require_once realpath( __DIR__ ) . '/controllers/MenuController.php';
require_once realpath( __DIR__ ) . '/controllers/DashboardController.php';
require_once realpath( __DIR__ ) . '/controllers/AdvisorController.php';
require_once realpath( __DIR__ ) . '/controllers/LogController.php';
require_once realpath( __DIR__ ) . '/controllers/ServiceController.php';
require_once realpath( __DIR__ ) . '/controllers/404Controller.php';
require_once realpath( __DIR__ ) . '/controllers/ServerInfoController.php';
require_once realpath( __DIR__ ) . '/controllers/NotificatorController.php';
require_once realpath( __DIR__ ) . '/controllers/ReviewController.php';
ISTKR_MenuController::istkr_init();
ISTKR_HooksController::istkr_init();