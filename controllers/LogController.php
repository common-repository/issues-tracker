<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once realpath(__DIR__) . '/../vendor/autoload.php';
require_once realpath(__DIR__) . '/../models/LogModel.php';
require_once realpath(__DIR__) . '/../views/pages/log.php';
require_once realpath(__DIR__) . '/../helpers/utils.php';
require_once realpath(__DIR__) . '/ScheduleTrait.php';

use WpConfigTransformer\Transformers\ConfigTransformer;


class ISTKR_LogController
{
    use ScheduleTrait;

    const SCHEDULE_MAIL_SEND = 'ISTKR_NOTIFY_LOG_CONTROLLER';

    private $config_editor;

    public function __construct()
    {
        try {
            $this->config_editor = new WPConfigTransformer(ISTKR_Constants::get_wp_config_path());
        } catch (Exception $error) {
            // Please, make sure permissions and path is correct.
            // The plugin need an access to wp-config.php to manage debugging constants
        }
    }

    public static function istkr_render_view()
    {
        return ISTKR_LogView::istkr_render_view();
    }

    public static function istkr_get_debug_file_path()
    {
        if (file_exists(WP_CONTENT_DIR . '/debug.log')) {
            return WP_CONTENT_DIR . '/debug.log';
        }

        return '';
        // For those cases when WP_DEBUG_LOG is setted as a path to debug file (overrided default)
        // @todo: return WP_DEBUG_LOG;
    }

    public static function istkr_get_log_data()
    {
        verify_nonce($_POST);

        $draw = isset($_POST['draw']) ? (int) $_POST['draw'] : 0;
        $start = isset($_POST['start']) ? (int) $_POST['start'] : 1;
        $length = isset($_POST['length']) ? (int) $_POST['length'] : 25;
        $search_value = isset($_POST['search']['value']) ? sanitize_text_field($_POST['search']['value']) : null;

        $storage = [];

        $rows = array_reverse(ISTKR_LogModel::istkr_parse_log_file());

        if (!$rows) {
            echo json_encode([
                'success' => true,
                'data' => [],
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
            ]);
            wp_die();
        }

        $storage = [];
        $rows_count = 0;
        foreach ($rows as $row) {

            if (empty($row)) {
                continue;
            }

            $storage[] = [
                'datetime'    => ISTKR_LogModel::istkr_get_datetime_from_row($row),
                'line'        => ISTKR_LogModel::istkr_get_line_from_log_row($row),
                'file'        => ISTKR_LogModel::istkr_get_file_from_log_row($row),
                'type'        => ISTKR_LogModel::istkr_get_type_from_row($row),
                'description' => [
                    'text' => ISTKR_LogModel::istkr_get_description_from_row($row),
                    'stack_trace' => ISTKR_LogModel::istkr_get_stack_trace_for_row($row)
                ]
            ];

            $rows_count++;
        }

        if ($search_value) {
            $search_string = trim(strtolower($search_value));
            $data = [];
            foreach ($storage as $index => $row) {
                $results = find_string($row, $search_string);

                if ($results) {
                    $data[] = $storage[$index];
                }
            }

            $search_results_length = count($data);

            $storage = array_slice($data, $start, $length);
        } else {
            $storage = array_slice($storage, $start, $length);
        }

        $filesize = ISTKR_LogModel::istkr_get_log_filesize(['with_measure_units' => true]);

        if (ISTKR_LogModel::istkr_is_debug_log_too_big()) {
            $template = __("The debug log file is excessively large (%s). We only parse the most recent %d lines, starting from the date %s.");
            $info = sprintf($template, $filesize, $rows_count, ISTKR_LogModel::istkr_get_datetime_from_row($rows[0]));
        } else {
            $info = null;
        }

        echo json_encode([
            'success' => true,
            'data' => $storage ? $storage : [],
            'draw' => $draw,
            'recordsTotal' => $rows_count,
            'recordsFiltered' => $search_value ? $search_results_length : $rows_count,
            'info' => $info,
        ]);
        wp_die();
    }

    public static function istkr_get_log_stat()
    {
        verify_nonce($_POST);
        $rows = ISTKR_LogModel::istkr_parse_log_file(null, 0);

        if (!$rows) {
            echo json_encode([
                'success' => true,
                'data' => [],
            ]);
            wp_die();
        }

        $timestamp = strtotime(ISTKR_LogModel::istkr_get_datetime_from_row($rows[count($rows) - 1]));

        $storage = [
            'notice' => 0,
            'warning' => 0,
            'fatal' => 0,
            'database' => 0,
            'total' => $rows ? count($rows) : 0,
            'filesize' => ISTKR_LogModel::istkr_get_log_filesize(['with_measure_units' => true]),
            'last_error_datetime' => date('d-M H:i', $timestamp),
        ];

        foreach ($rows as $row) {
            switch (ISTKR_LogModel::istkr_get_type_from_row($row)) {
                case 'Notice':
                    $storage['notice'] += 1;
                    break;
                case 'Warning':
                    $storage['warning'] += 1;
                    break;
                case 'Fatal':
                    $storage['fatal'] += 1;
                    break;
                case 'Database':
                    $storage['database'] += 1;
                    break;
            };
        }

        echo json_encode([
            'success' => true,
            'data' => $storage,
        ]);

        wp_die();
    }

    public function istkr_log_viewer_enable_logging()
    {
        verify_nonce($_POST);
        try {

            $path = WP_CONTENT_DIR . '/debug.log';
            if (!is_file($path) || !file_exists($path)) {
                // Create debug.log if missing
                $message = 'This is a demo entry. Debugging is now enabled. If any notices, warnings, or errors occur on your site, they will appear here. Remember to refresh the table to view the latest entries';

                $demo_string = "[" . date('d-M-Y H:i:s T') . "] PHP Notice: <b>" . $message  . "</b>  in " . $_SERVER['DOCUMENT_ROOT'] . "/example.php on line 0\n";
                file_put_contents($path, $demo_string);
            }

            $this->config_editor->update('constant', 'WP_DEBUG', '1');
            $this->config_editor->update('constant', 'WP_DEBUG_LOG', '1');

            echo json_encode([
                'success' => true,
            ]);
            wp_die();
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            wp_die();
        }
    }

    public function istkr_toggle_debug_mode()
    {
        verify_nonce($_POST);
        $state = $this->istkr_prepare_state();

        try {
            $this->config_editor->update('constant', 'WP_DEBUG', $state);

            echo json_encode([
                'success' => true,
                'state' => (int) $state ? "ON" : "OFF",
            ]);
            wp_die();
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            wp_die();
        }
    }

    public function istkr_toggle_debug_scripts()
    {
        verify_nonce($_POST);
        $state = $this->istkr_prepare_state();

        try {
            $this->config_editor->update('constant', 'SCRIPT_DEBUG', $state);

            echo json_encode([
                'success' => true,
                'state' => (int) $state ? "ON" : "OFF",
            ]);
            wp_die();
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            wp_die();
        }
    }

    public function istkr_toggle_debug_log_scripts()
    {
        verify_nonce($_POST);
        $state = $this->istkr_prepare_state();

        try {
            if ($state == '1') {
                $this->config_editor->update('constant', 'WP_DEBUG', $state);
            }

            $this->config_editor->update('constant', 'WP_DEBUG_LOG', $state);

            echo json_encode([
                'success' => true,
                'state' => (int) $state ? "ON" : "OFF",
            ]);
            wp_die();
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            wp_die();
        }
    }

    public function istkr_toggle_display_errors()
    {
        verify_nonce($_POST);
        $state = $this->istkr_prepare_state();

        try {
            if ($state == '1') {
                $this->config_editor->update('constant', 'WP_DEBUG', $state);
            }

            $this->config_editor->update('constant', 'WP_DEBUG_DISPLAY', $state);

            echo json_encode([
                'success' => true,
                'state' => (int) $state ? "ON" : "OFF",
            ]);
            wp_die();
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            wp_die();
        }
    }

    public static function istkr_clear_log()
    {
        verify_nonce($_POST);

        try {
            $debug_log_path = ISTKR_LogController::istkr_get_debug_file_path();

            if (is_file($debug_log_path) && file_exists($debug_log_path)) {

                if (is_writable($debug_log_path)) {
                    file_put_contents($debug_log_path, '');

                    echo json_encode([
                        'success' => true
                    ]);
                    wp_die();
                }

                throw new \Exception('Log file was found but can not to be cleared due to missing write permissions');
            }
            throw new \Exception('Log file is not found and can not to be removed');
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
            wp_die();
        }
    }

    public static function istkr_download_log()
    {
        verify_nonce($_POST);
        try {
            $debug_log_path = ISTKR_LogController::istkr_get_debug_file_path();

            if (is_file($debug_log_path) && file_exists($debug_log_path)) {

                $basename = basename($debug_log_path);
                $filesize = filesize($debug_log_path);

                header('Content-Description: File Transfer');
                header('Content-Type: text/plain');
                header("Cache-Control: no-cache, must-revalidate");
                header("Expires: 0");
                header("Content-Disposition: attachment; filename=$basename");
                header("Content-Length: $filesize");
                header('Pragma: public');

                flush();

                readfile($debug_log_path);
                wp_die();
            }

            throw new \Exception('Log file is not found and can not to be removed');
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        } finally {
            wp_die();
        }
    }

    public function istkr_prepare_state()
    {
        verify_nonce($_POST);

        if (!isset($_POST["state"])) {
            throw new \Exception('Empty state passed');
        }

        $state = $_POST["state"];
        switch ((int) $state) {
            case 0:
            case 1:
                return (string) $state;
            default:
                throw new \Exception('Incorrect state value passed');
        }
    }

    public static function istkr_parse_critical_log_errors($recurrence)
    {
        global $WP_CRON_SCHEDULE_INTERVALS;
        global $ISTKR_LOG_VIEWER_EMAIL_LEVELS;

        $rows = ISTKR_LogModel::istkr_parse_log_file();

        if (!$rows) {
            return;
        }

        $errors = [];
        foreach ($ISTKR_LOG_VIEWER_EMAIL_LEVELS as $level) {
            $errors[$level] = [];
        }

        $new_lines = 0;
        foreach ($rows as $row) {
            if (empty($row)) {
                continue;
            }

            $datetime = ISTKR_LogModel::istkr_get_datetime_from_row($row);
            $datetimeOffset = new DateTime();
            $datetimeOffset->sub($WP_CRON_SCHEDULE_INTERVALS[$recurrence]);
            $datetimeError = new DateTime();
            $datetimeError->setTimestamp(strtotime($datetime));

            if ($datetimeError < $datetimeOffset) {
                continue;
            }

            $type = ISTKR_LogModel::istkr_get_type_from_row($row);

            if (!in_array($type, $ISTKR_LOG_VIEWER_EMAIL_LEVELS)) {
                continue;
            }

            $line = ISTKR_LogModel::istkr_get_line_from_log_row($row);
            $file = ISTKR_LogModel::istkr_get_file_from_log_row($row);
            $text = ISTKR_LogModel::istkr_get_description_from_row($row);
            $hash = md5($line . '::' . $file . '::' . $text);

            if (array_key_exists($hash, $errors[$type])) {
                $errors[$type][$hash]['hits'] += 1;
            } else {
                $errors[$type][$hash] = [
                    'datetime'    => $datetime,
                    'line'        => $line,
                    'file'        => $file,
                    'type'        => $type,
                    'description' => [
                        'text' => $text,
                        'stack_trace' => ISTKR_LogModel::istkr_get_stack_trace_for_row($row),
                    ],
                    'hits' => 1,
                ];
            }
            $new_lines += 1;
        }

        return $new_lines ? $errors : null;
    }

    public static function istkr_send_logs_handler($event)
    {
        $options = get_option($event);

        if (!$options) {
            error_log('Options not found for event ' . $event);
            wp_die();
        }

        if (!array_key_exists('notifications_email', $options)) {
            error_log('Notification email not found in options for event ' . $event);
            wp_die();
        }

        if (!array_key_exists('notifications_email_recurrence', $options)) {
            error_log('Notification email recurrence not found in options for event ' . $event);
            wp_die();
        }

        $notification_email = $options['notifications_email'];
        $recurrence = $options['notifications_email_recurrence'];
        $errors = self::istkr_parse_critical_log_errors($recurrence);

        if ($notification_email && $errors) {
            istkr_send_log_viewer_email(
                $notification_email,
                'Issues Tracker: Log monitoring detected serious problem on the website',
                realpath(__DIR__) . '/../templates/email/log_viewer.tpl',
                [
                    'website' => get_site_url(),
                    'errors' => $errors,
                ]
            );
        }
    }

    public static function istkr_change_log_notifications_status()
    {
        verify_nonce($_POST);

        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : null;
        if ($status) {
            $config_editor = new WPConfigTransformer(ISTKR_Constants::get_wp_config_path());

            if (!WP_DEBUG) {
                $config_editor->update('constant', 'WP_DEBUG', '1');
            }

            if (!WP_DEBUG_LOG) {
                $config_editor->update('constant', 'WP_DEBUG_LOG', '1');
            }
        }

        if (!ISTKR_LogModel::istkr_is_log_file_exists()) {
            echo json_encode([
                'success' => false,
                'error' => __('Unable to set Email notifications as the log file does not exist.', 'istkr')
            ]);
            wp_die();
        }

        self::istkr_change_notifications_status();
    }

    public static function istkr_log_viewer_deactivate()
    {
        $notificator = new ISTKR_Notificator(new self());

        if ($notificator->istkr_is_notification_enabled()) {
            self::istkr_delete_wp_schedule_event($notificator->istkr_build_unique_event_name());
        }

        wp_unschedule_hook(self::SCHEDULE_MAIL_SEND);
        delete_option(ISTKR_DEBUG_LOG_LAST_FILESIZE);
    }

    public static function istkr_live_update()
    {
        $script_execution_time = 70;

        set_time_limit($script_execution_time);
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('Accept: application/json');

        for ($counter = 0; $counter < $script_execution_time - 10; $counter += 5) {
            clearstatcache();

            $filesize = ISTKR_LogModel::istkr_get_log_filesize(['raw' => true]);
            $last_filesize = (int) get_option(ISTKR_DEBUG_LOG_LAST_FILESIZE);

            if ($filesize !== $last_filesize) {

                update_option(ISTKR_DEBUG_LOG_LAST_FILESIZE, $filesize);

                $fields = [
                    'id'    => $filesize,
                    'event' => 'updates',
                    'data'  => json_encode(['updated' => true]),
                    'retry' => 5000,
                ];

                foreach ($fields as $field => $value) {
                    echo "$field: $value" . PHP_EOL;
                }

                echo PHP_EOL;
            }

            while (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();

            sleep(5);
        };
    }
}
