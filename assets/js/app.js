
{
    import("./init.js");

    try {
        switch (new URL(location.href).searchParams.get('page')) {
            case 'issues-tracker-dashboard':
                import("./components/dashboard.js");
                istkr_sendComponentEvent('dashboard');
                break;
            case 'issues-tracker-log-viewer':
                import("./components/log-view.js");
                istkr_sendComponentEvent('log view');
                break;
            case 'issues-tracker-advisor':
                import("./components/advisor.js");
                istkr_sendComponentEvent('advisor');
                break;
            case 'issues-tracker-404':
                import("./components/404.js");
                istkr_sendComponentEvent('404');
                break;
            case 'issues-tracker-server-info':
                import("./components/server-info.js");
                istkr_sendComponentEvent('server-info');
                break;
        }
    } catch (error) {
        console.log(error);
    }

    function istkr_sendComponentEvent(component) {

        if (!istkr_backend_data.is_dev) {
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', istkr_backend_data.anatylics_id);
            gtag('event', 'page_open', {'event_category': 'Components events', 'event_label': `Opened ${component}`});
        }
    }
}

