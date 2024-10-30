<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once realpath( __DIR__ ) . '/../helpers/constants.php';


class ISTKR_Migrations
{

    public static function istkr_is_column_exists($table, $column)
    {
        global $wpdb;
        
        $result = $wpdb->get_results("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND table_name = '" . $table . "' AND column_name = '" . $column . "'");

        return !empty($result);
    }

    public static function istkr_migrate()
    {
        global $wpdb;

        if (!self::istkr_is_column_exists(ISTKR_404_LOG, 'ip')) {
            $wpdb->query("ALTER TABLE `" . ISTKR_404_LOG . "` ADD `ip` varchar(128) NULL AFTER `referrer`");
        }

        if (!self::istkr_is_column_exists(ISTKR_404_LOG, 'user_agent')) {
            $wpdb->query("ALTER TABLE `" . ISTKR_404_LOG . "` ADD `user_agent` varchar(255) NULL AFTER `ip`");
        }

    }
}
