<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $wpdb;

define('ISTKR_404_LOG', $wpdb->prefix . 'istkr_404_log');
define('ISTKR_LOG_FILE_LIMIT', 10 * 1024 * 1024);
define('ISTKR_IP_INFO_TOKEN', '8ac2a0fd945019');
define('ISTKR_DEBUG_LOG_LAST_FILESIZE', 'istkr_dbg_log_last_filesize');
define('ISTKR_SITE_UNDER_ATTACK_TIME_PERIOD', 10);
define('ISTKR_SITE_UNDER_ATTACK_404_COUNT', 10);


class ISTKR_Constants
{
    public static $GA_ID = 'G-YXQLGB35QJ';
    public static $GTM_ID = 'GTM-PSVZCC4';

    public static function get_wp_config_path()
    {
        // Starting from the current directory
        $dir = dirname(__FILE__);

        // Traverse up to 10 levels to avoid infinite loops
        for ($i = 0; $i < 10; $i++) {
            if (file_exists($dir . '/wp-config.php')) {
                return realpath($dir . '/wp-config.php');
            }
            // Move up one directory level
            $dir = dirname($dir);
        }
        return 'wp-config.php not found!';
    }

    const WEEK_IN_SECONDS = 604800;
    const TWO_MONTH_IN_SECONDS = 5259492;
    const SIX_MONTH_IN_SECONDS = 15778476;
}

class ISTKR_LogLevelStatuses
{
    const NOTICE = 'Notice';
    const WARNING = 'Warning';
    const FATAL = 'Fatal';
    const DATABASE = 'Database';
    const PARSE = 'Parse';
    const DEPRECATED = 'Deprecated';
}

$WP_CRON_SCHEDULE_INTERVALS = [
    'hourly'     => new DateInterval('PT1H'),
    'twicedaily' => new DateInterval('PT12H'),
    'daily'      => new DateInterval('P1D'),
    'weekly'     => new DateInterval('P7D'),
];

$ISTKR_LOG_VIEWER_EMAIL_LEVELS = [
    ISTKR_LogLevelStatuses::DATABASE,
    ISTKR_LogLevelStatuses::FATAL,
    ISTKR_LogLevelStatuses::PARSE,
    ISTKR_LogLevelStatuses::DEPRECATED,
];
