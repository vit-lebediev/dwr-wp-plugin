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
    load_plugin_textdomain(DWR_PLUGIN_NAME, false, dirname( plugin_basename( __FILE__ ) ) . '/../languages');

    if (!dwr_required_fields_are_set()) {
        return; // can't do much without settings properly set
    }

    // Get saved part of URL which serves as result URL
    $result_url = get_option('dwr_result_url');

    $merchant_login = get_option('dwr_merchant_login');
    $robokassaService = new DWRRobokassaService($merchant_login, dwr_get_blog_language_for_robokassa());

    // Get current URI part
    $real_url = $_SERVER['REQUEST_URI'];
    preg_match('/^\/([^\?]*)(\?.+)?$/i', $real_url, $real_matches);

    // Check if current URI is the same as result
    if ($real_matches[1] === $result_url) {
        $result_url_method = get_option('dwr_result_url_method');
        switch ($result_url_method) {
            case 'POST':
                if (isset($_POST['SignatureValue'])) {
                    $InvId = $_POST["InvId"];
                    $SignatureValue = $_POST["SignatureValue"];
                    $robokassaService->processResult($InvId, $SignatureValue);
                }
                break;
            case 'GET':
                if (isset($_GET['SignatureValue'])) {
                    $InvId = $_GET["InvId"];
                    $SignatureValue = $_GET["SignatureValue"];
                    $robokassaService->processResult($InvId, $SignatureValue);
                }
                break;
            default: break;
        }
    }
}

function admin_init_plugin()
{
    // Register plugin options in admin panel
    register_setting('dwr_plugin_options', 'dwr_confirm_page_url');

    register_setting('dwr_plugin_options', 'dwr_result_url');
    register_setting('dwr_plugin_options', 'dwr_result_url_method'); // TODO: Add validation, check for possible values (GET AND POST)

    register_setting('dwr_plugin_options', 'dwr_merchant_login');
    register_setting('dwr_plugin_options', 'dwr_merchant_pass_one');
    register_setting('dwr_plugin_options', 'dwr_merchant_pass_two');

    register_setting('dwr_plugin_options', 'dwr_text_before_donate_form');
    register_setting('dwr_plugin_options', 'dwr_operation_description');

    register_setting('dwr_plugin_options', 'dwr_force_delete_tables');
}
