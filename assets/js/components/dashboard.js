(async ($) => {

    if ($('.istkr-dashboard').length) {

        {
            const logResponse = await jQuery.post(ajaxurl, {
                action: 'istkr_get_log_stat',
                wp_nonce: istkr_backend_data.ajax_nonce
            });

            let logData = JSON.parse(logResponse);

            if (!logData.success) {
                // @toto: Replace the alert to Tippy or ebmedded in a UI Kit warning
                alert('Error occured while getting statistic');
            } else {
                const cardSection = $('.module-card.log');

                cardSection.find('.info span').html(logData.data.last_error_datetime)
                cardSection.find('.filesize span').html(logData.data.filesize)

                if (!istkr_backend_data.is_dev) {
                    window.dataLayer = window.dataLayer || [];
                    function gtag() { dataLayer.push(arguments); }
        
                    gtag('js', new Date());
                    gtag('config', istkr_backend_data.anatylics_id);
                    gtag('event', `Log size: ${logData.data.filesize}`, { 
                        'event_category': 'Components events'
                    });
                }
            }
        }

        {
            let good = 0;
            let bad = 0;
            [
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
            ].forEach(async check => {

                const rawResponse = await jQuery.post(ajaxurl, {
                    action: 'istkr_run_check',
                    wp_nonce: istkr_backend_data.ajax_nonce,
                    check
                });
    
                let response = JSON.parse(rawResponse);

                if (!response.success) {
                    // @toto: Replace the alert to Tippy or ebmedded in a UI Kit warning
                    alert('Request error');
                    return;
                }

                const data = response.data;

                if (data.state === 'Passed') {
                    good++;
                } else if (data.state === 'Failed') {
                    bad++;
                }

                $('.module-card.advisor .info :nth-child(1) .count').html(good);
                $('.module-card.advisor .info :nth-child(2) .count').html(bad);

            });
        }

        {

            const rawResponse = await jQuery.post(ajaxurl, {
                action: 'istkr_get_404_count',
                wp_nonce: istkr_backend_data.ajax_nonce
            });

            let response = JSON.parse(rawResponse);

            if (!response.success) {
                // @toto: Replace the alert to Tippy or ebmedded in a UI Kit warning
                alert('Request error');
                return;
            }

            $('.module-card.404 .card-title .count').html(response.data);


        }
    }

})(jQuery)
