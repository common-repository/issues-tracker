<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once realpath(__DIR__) . '/../views/pages/dashboard.php';


class ISTKR_DashboardController
{
    public static function istkr_render_view()
    {
        return ISTKR_DashboardView::istkr_render_view();
    }
}
