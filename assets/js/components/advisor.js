import { updateEmailNotifications } from '../utils.js';
import { initEmailNotificationsForm } from '../utils.js';


(async ($) => {

    const checks = [
        'istkr_advice_database_prefix',
        'istkr_advice_database_username',
        'istkr_advice_database_password',
        'istkr_advice_outdated_php',
        'istkr_advice_users_with_popular_logins',
        'istkr_advice_is_ssl_enabled',
        'istkr_advice_is_wp_ver_displayed',
        'istkr_advice_is_display_errors_enabled',
        'istkr_advice_free_disk_space',
        'istkr_advice_search_visibility'
    ];

    let totalSuccess = 0;
    let totalWarning = 0;
    let totalTests = checks.length;

    if ($('.istkr-advisor')) {
        checks.forEach(async check => {

            const rawResponse = await jQuery.post(ajaxurl, {
                action: 'istkr_run_check',
                wp_nonce: istkr_backend_data.ajax_nonce,
                check
            });

            let response = JSON.parse(rawResponse);

            if (!response.success) {
                toastr.error(response.error, 'Error', { timeOut: 5000 });
                return
            }

            const data = response.data;
            $(`#${check}_body .accordion-body`).append(`<p>${data?.meta?.recommendation}</p>`);

            if (data.state === 'Passed') {

                totalSuccess++;
                const value = `${((totalSuccess * 100) / totalTests).toFixed(1)}%`;

                $(`.istkr-advisor-progress-bar .success`).attr('style', `width: ${value}`);

                $(`#${check} .status-badge`).html('<i class="fa-solid fa-circle-check"></i>').removeClass('unknown').addClass('success');
            } else {

                totalWarning++;
                const value = `${(totalWarning * 100 / totalTests).toFixed(1)}%`;

                $(`.istkr-advisor-progress-bar .fail`).attr('style', `width: ${value};`);
                
                $(`#${check} .status-badge`).html('<i class="fa-solid fa-circle-xmark"></i>').removeClass('unknown').addClass('fail');
            }
        });
    }

    await initEmailNotificationsForm($('#istkr_advisor_notifications_form'));

    $('#istkr_advisor_notifications_form').on('submit', async function (e) {
        e.preventDefault();

        const form = $('#istkr_advisor_notifications_form');
        const action = 'istkr_change_advisor_notifications_status';

        await updateEmailNotifications(form, action);
    });

})(jQuery);
