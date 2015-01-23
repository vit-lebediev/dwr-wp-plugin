<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 23.01.15
 * Time: 17:49
 */

function init_plugin()
{
    // Localization
    load_plugin_textdomain('domain', false, dirname(plugin_basename(__FILE__)) . "/languages");

    // Check for proper POST or GET variables and process Robokassa request if it is present

    // Get saved part of URL which serves as result URL
    $result_url = get_option('dwr_result_url');

    // Get current URI part
    $real_url = $_SERVER['REQUEST_URI'];
    preg_match('/^\/([^\?]*)(\?.+)?$/i', $real_url, $real_matches);

    // Check if current URI is the same as result
    if ($real_matches[1] == $result_url) {
        $result_url_method = get_option('dwr_result_url_method');
        switch ($result_url_method) {
            case 'POST':
                if (isset($_POST['SignatureValue'])) {
                    $InvId = $_POST["InvId"];
                    $SignatureValue = $_POST["SignatureValue"];
                    process_robokassa($InvId, $SignatureValue);
                }
                break;
            case 'GET':
                if (isset($_GET['SignatureValue'])) {
                    $InvId = $_GET["InvId"];
                    $SignatureValue = $_GET["SignatureValue"];
                    process_robokassa($InvId, $SignatureValue);
                }
                break;
            default: break;
        }
    }
}

function admin_init_plugin()
{
    // Register plugin options in admin panel
    register_setting('dwr_plugin_options', 'dwr_result_url');
    register_setting('dwr_plugin_options', 'dwr_result_url_method');// TODO: Add validation, check for possible values (GET AND POST)
}
