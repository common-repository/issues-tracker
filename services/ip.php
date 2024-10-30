<?php

require_once __DIR__ . '/ip_info/IPinfo.php';


function istkr_get_ip_address()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
            {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false)
                {
                    return $ip;
                }
            }
        }
    }
}


function istkr_get_country_info_by_ip($ip)
{
    global $wpdb;

    if (in_array($ip, ['::1', '127.0.0.1', 'localhost'])) {
        return [
            'country_name' => 'localhost',
            'country_flag' => null,
        ];
    }

    $row = $wpdb->get_row(
        $wpdb->prepare("SELECT country_flag, country_name FROM `" . ISTKR_404_LOG . "` WHERE `ip` = %s LIMIT 1", $ip)
    );

    if (isset($row)) {
        $country_flag = $row->country_flag;
        $country_name = $row->country_name;
    } else {
        $client = new ISTKR_IPinfo(ISTKR_IP_INFO_TOKEN);
        $details = $client->getDetails($ip);

        $country_flag = $details->country_flag['emoji'];
        $country_name = $details->country_name;
    }

    return [
        'country_name' => $country_name,
        'country_flag' => $country_flag,
    ];
}
