<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

require_once realpath( __DIR__ ) . '/../helpers/constants.php';
require_once realpath( __DIR__ ) . '/../models/AdvisorModel.php';
require_once realpath( __DIR__ ) . '/../views/pages/advisor.php';
require_once realpath(__DIR__) . '/ScheduleTrait.php';
require_once realpath(__DIR__) . '/../helpers/utils.php';


class ISTKR_AdvisorController
{
    use ScheduleTrait;

    const SCHEDULE_MAIL_SEND = 'ISTKR_NOTIFY_ADVISOR';

    public static function istkr_render_view()
    {
        return ISTKR_AdvisorView::istkr_render_view();
    }

    public static function istkr_run_check()
    {
        verify_nonce($_POST);

        try {
            $check_name = sanitize_text_field($_POST['check']);
            echo json_encode([
                'success' => true,
                'data'    => call_user_func('ISTKR_AdvisorModel::' . $check_name),
            ]);
            wp_die();
        } catch (Exception $e) {
            echo  json_encode([
                'success' => false,
                'error'   => $e->getMessage(),
            ]);
            wp_die();
        }
    }
    
    public static function istkr_advisor_checks_handler($event)
    {
        global $WP_CRON_SCHEDULE_INTERVALS;
        
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
        $checks = ISTKR_AdvisorModel::istkr_run_checks();

        $failed_checks = array_filter($checks, function ($state, $name) {
            return $state == __('Failed', 'istkr');
        }, ARRAY_FILTER_USE_BOTH);

        $currentDateTime = new DateTime();
        $checkDatetime = $currentDateTime->format('d-M-Y H:i');
        $nextCheckDatetime = $currentDateTime->add($WP_CRON_SCHEDULE_INTERVALS[$recurrence]);

        if ($notification_email && $failed_checks) {
            istkr_send_advisor_email(
                $notification_email,
                'Detected the problems on your website at ' . $checkDatetime,
                realpath(__DIR__) . '/../templates/email/advisor.tpl',
                [
                    'website' => get_site_url(),
                    'summary' => ISTKR_AdvisorModel::render_advisor_checks($failed_checks),
                    'next_check' => $nextCheckDatetime->format('d-M-Y H:i'),
                    'change_recurrence' => admin_url() . 'admin.php?page=issues-tracker-advisor',
                ]
            );
        }
    }

    public static function istkr_advisor_deactivate()
    {
        $notificator = new ISTKR_Notificator(new self());
        
        if ($notificator->istkr_is_notification_enabled()) {
            self::istkr_delete_wp_schedule_event($notificator->istkr_build_unique_event_name());
        }
        
        wp_unschedule_hook(self::SCHEDULE_MAIL_SEND);
    }
}
