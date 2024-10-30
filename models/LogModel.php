<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class ISTKR_LogModel
{
    public static $database_directory = WP_CONTENT_DIR . './issues-tracker-db';

    public static function istkr_is_log_file_exists()
    {
        $path = ISTKR_LogController::istkr_get_debug_file_path();

        return $path && file_exists($path) && is_file($path);
    }

    public static function istkr_get_actual_log_limit()
    {
        return defined('ISTKR_USER_DEFINED_LOG_FILE_LIMIT') ? constant('ISTKR_USER_DEFINED_LOG_FILE_LIMIT') : ISTKR_LOG_FILE_LIMIT;
    }

    public static function istkr_is_debug_log_too_big()
    {
        return self::istkr_get_log_filesize(['raw' => true]) > self::istkr_get_actual_log_limit();
    }

    public static function istkr_get_log_content($filename)
    {
        if (self::istkr_is_debug_log_too_big()) {
            $actual_limit = self::istkr_get_actual_log_limit();
            $file_handle = fopen($filename, 'r');
            fseek($file_handle, -$actual_limit, SEEK_END);
            $content = fread($file_handle, $actual_limit);
            fclose($file_handle);
            return $content;
        } else {
            return file_get_contents($filename);
        }
    }

    public static function istkr_parse_log_file()
    {
        $path = ISTKR_LogController::istkr_get_debug_file_path();

        if (!file_exists($path) || !is_file($path)) {
            return false;
        }

        $file = self::istkr_get_log_content($path);

        $pattern = '/\[.{1,20} \w{1,3}\](.*)( on line )\d*?/sU';
        $count = preg_match_all($pattern, $file, $matches);

        if (!$count) {
            return [];
        }

        return $matches[0];
    }

    public static function istkr_get_datetime_from_row($row)
    {
        preg_match_all('/\[(.*?)\]/m', $row, $matches, PREG_SET_ORDER, 0);
        return isset($matches[0][1]) ? $matches[0][1] : __('N/A', 'istkr');
    }

    public static function istkr_get_line_from_log_row($row)
    {
        preg_match_all('/(on line |php:)(\d{1,})/m', $row, $matches, PREG_SET_ORDER, 0);
        return isset($matches[0][2]) ? $matches[0][2] : __('N/A', 'istkr');
    }

    public static function istkr_get_file_from_log_row($row)
    {
        preg_match_all('/ in ' . preg_quote($_SERVER['DOCUMENT_ROOT'], '/') . '(.*?)( on line |:)\d{1,}/m', $row, $matches, PREG_SET_ORDER, 0);
        return isset($matches[0][1]) ? $matches[0][1] : __('N/A', 'istkr');
    }

    public static function istkr_get_type_from_row($row)
    {
        if (strpos($row, 'PHP Notice:') !== false) {
            return ISTKR_LogLevelStatuses::NOTICE;
        } elseif (strpos($row, 'PHP Warning:') !== false) {
            return ISTKR_LogLevelStatuses::WARNING;
        } elseif (strpos($row, 'PHP Fatal error:') !== false) {
            return ISTKR_LogLevelStatuses::FATAL;
        } elseif (strpos($row, 'WordPress database error') !== false) {
            return ISTKR_LogLevelStatuses::DATABASE;
        } elseif (strpos($row, 'PHP Parse error:') !== false) {
            return ISTKR_LogLevelStatuses::PARSE;
        } elseif (strpos($row, 'PHP Deprecated:') !== false) {
            return ISTKR_LogLevelStatuses::DEPRECATED;
        }
    }

    public static function istkr_get_stack_trace_for_row($row)
    {
        $re = '/Stack trace:\n(.*?)thrown in/s';
        preg_match_all($re, $row, $matches, PREG_SET_ORDER, 0);
        if (isset($matches[0])) {
            return $matches[0][1];
        }
        return null;
    }

    public static function istkr_get_description_from_row($row)
    {
        if (self::istkr_get_type_from_row($row) === 'Database') {

            $re = '/WordPress database error (.*)/m';
            preg_match_all($re, $row, $matches, PREG_SET_ORDER, 0);
            return isset($matches[0]) && $matches[0][1] ? $matches[0][1] : __('N/A', 'istkr');
        }

        $re = '/ (PHP Notice:|PHP Warning:|PHP Fatal error:|PHP Parse error:|PHP Deprecated:)(.*?)(\[ | in |on line)/m';
        preg_match_all($re, $row, $matches, PREG_SET_ORDER, 0);
        return isset($matches[0]) && $matches[0][2] ? $matches[0][2] : __('N/A', 'istkr');
    }

    public static function istkr_get_log_filesize($params)
    {
        $with_measure_units = isset($params['with_measure_units']) ? $params['with_measure_units'] : null;
        $raw = isset($params['raw']) ? $params['raw'] : null;

        $debug_filepath = ISTKR_LogController::istkr_get_debug_file_path();

        if (is_file($debug_filepath) && filesize($debug_filepath)) {
            $filesize_in_bytes = filesize($debug_filepath);
            if ($raw) {
                return $filesize_in_bytes;
            }
            $filesize_in_mb = $filesize_in_bytes / 1024 / 1024;
            return $with_measure_units ? round($filesize_in_mb, 2) . ' ' . __('Mb', 'istkr') :  round($filesize_in_mb, 2);
        } else {
            return 0;
        }
    }

    public static function render_log_viewer_errors($errors)
    {
        global $ISTKR_LOG_VIEWER_EMAIL_LEVELS;

        $body = "" .
            "<tr>" .
            "    <td>#</td>" .
            "    <td>Type</td>" .
            "    <td>Description</td>" .
            "    <td>File</td>" .
            "    <td>Line</td>" .
            "    <td>Hits</td>" .
            "</tr>";

        $row = "" .
            "<tr>" .
            "    <td>%s</td>" .
            "    <td>%s</td>" .
            "    <td>%s</td>" .
            "    <td>%s</td>" .
            "    <td>%s</td>" .
            "    <td>%d</td>" .
            "</tr>";

        $index = 1;
        foreach ($ISTKR_LOG_VIEWER_EMAIL_LEVELS as $level) {
            foreach ($errors[$level] as $hash => $error) {
                $body .= sprintf($row, $index, $error['type'], $error['description']['text'], $error['file'], $error['line'], $error['hits']);
                $index += 1;
            }
        }

        return $body;
    }
}
