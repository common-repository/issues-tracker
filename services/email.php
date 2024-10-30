<?php


function render_404_table_body($params)
{
    $body = "" .
        "<tr>" .
        "    <td>URL</td>" .
        "    <td>Last seen datetime</td>" .
        "    <td>IP</td>" .
        "    <td>Country</td>" .
        "    <td>Referrer</td>" .
        "</tr>";

    $row = "" .
        "<tr>" .
        "    <td>%s</td>" .
        "    <td>%s</td>" .
        "    <td>%s</td>" .
        "    <td>%s</td>" .
        "    <td>%s</td>" .
        "</tr>";

    foreach ($params as $param) {
        $country = !$param['country_flag'] && !$param['country_name'] ? 'Unknown' : $param['country_flag'] . ' ' . $param['country_name'];
        $body .= sprintf($row,
        $param['path'],
        $param['updated_at'],
        $param['ip'],
        $country,
        $param['referrer']);
    }

    return $body;
}


function istkr_send_404_email($notification_email, $subject, $template_name, $params)
{
    $template = file_get_contents($template_name);
    $template = str_replace('{{istkr_table}}', render_404_table_body($params['records']), $template);
    $template = str_replace('{{istkr_website}}', $params['website'], $template);

    wp_mail(
        $notification_email,
        $subject,
        $template,
        array('Content-Type: text/html; charset=UTF-8')
    );
}


function istkr_send_advisor_email($notification_email, $subject, $template_name, $params)
{
    $template = file_get_contents($template_name);

    foreach ($params as $key => $value) {
        $template = str_replace('{{istkr_' . $key . '}}', $value, $template);
    }

    wp_mail(
        $notification_email,
        $subject,
        $template,
        array('Content-Type: text/html; charset=UTF-8')
    );
}


function istkr_send_log_viewer_email($notification_email, $subject, $template_name, $params)
{
    $template = file_get_contents($template_name);
    $template = str_replace('{{istkr_summary}}', ISTKR_LogModel::render_log_viewer_errors($params['errors']), $template);
    $template = str_replace('{{istkr_website}}', $params['website'], $template);

    wp_mail(
        $notification_email,
        $subject,
        $template,
        array('Content-Type: text/html; charset=UTF-8')
    );
}
