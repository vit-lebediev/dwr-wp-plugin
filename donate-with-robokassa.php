<?php
/**
 * Plugin Name: Donate With Robokassa (DWR)
 * Plugin URI: ??? TO ADD
 * Description:
 *     A plugin which will help you integrate robokassa into your website to accept donations.
 *
 *     The plugin requires at least two pages (one of them can be replaced with widget) to work:
 *         - one page (or a widget) displays donation form
 *         - second (confirmation) page displays info about payment before user will be redirected to robokassa
 *
 *     The plugin provides complete log of all donations.
 * Version: 0.0.1
 * Author: Malgin
 * Author URI: malgin.name
 * License: GPL2
 *
 * TODO LIST:
 * - Use proper functions to work with numbers with floating point
 *
**/

define('DWR_DONATIONS_TABLE_NAME', 'dwr_donations');
define('DWR_PLUGIN_NAME', 'donate-with-robokassa');
define('DWR_ROBOKASSA_ACTION_URL', 'http://test.robokassa.ru/Index.aspx');

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
    // Init plugin options in admin panel
    register_setting('dwr_plugin_options', 'dwr_plugin_options', 'dwr_plugin_options_validator');
    add_settings_section('dwr_plugin_main', __('plugin_main_settings', DWR_PLUGIN_NAME), 'display_plugin_text', DWR_PLUGIN_NAME);
    add_settings_field('dwr_plugin_text_string', 'Plugin Text Input', 'display_plugin_setting_string', DWR_PLUGIN_NAME, 'dwr_plugin_main');
}

/**
 * This shortcode displays donation form, and should be placed on donation page or in some widget
 *
 * @param $attr
 * @return string
 */
function dwr_donate_form_shortcode()
{
    // form generated right here
    $form = '';

    $confirmation_page_url = get_option('dwr_confirm_page_url');

    if (!$confirmation_page_url) {
        $form = __('cannot_operate', DWR_PLUGIN_NAME); // "Not all required fields are filled in admin panel. This plugin cannot operate."
    } else {
        $action_url = $_SERVER['SERVER_NAME'] . "/" . $confirmation_page_url;

        $form .= '<div>' . __(get_option('dwr_text_before_donate_form'), DWR_PLUGIN_NAME) . '</div>';

        $form .= '<form action="' . $action_url . '" method="GET">';
        $form .= '<input type="text" name="OutSum" />';
        $form .= '<select name="IncCurrLabel">';
        $form .= '<option>WMZM</option>'; // TODO: request robokassa for currency options
        $form .= '</select>';
        $form .= '<input type="submit" value="' . __('donate', DWR_PLUGIN_NAME) . '"';
        $form .= '</form>';
    }

    return $form;
}

/**
 * This shortcode displays confirmation page, and should be placed on confirmation page
 *
 * @param $attr
 * @return string
 */
function dwr_confirm_form_shortcode()
{
    global $wpdb;

    $amount = $_GET['OutSum'];
    $currency = $_GET['IncCurrLabel'];

    $merchant_login = get_option('dwr_merchant_login');

    $form = '';

    // TODO: check data
    // TODO: check if amout is not negative
    if (!$merchant_login) {
        $form = __('cannot_operate', 'donate-with-robokassa'); // Not all required fields are filled in admin panel. This plugin cannot operate.
    } else {
        $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

        // create a new donate entry in DB
        $wpdb->insert(
            $table_donations,
            array(
                'amount' => $amount,
                'currency' => $currency,
                'start_date' => current_time('mysql', 1),
            ),
            array(
                '%f',
                '%s',
                '%s'
            )
        );

        $transaction_id = $wpdb->insert_id;

        $merchant_pass_one = get_option('dwr_merchant_pass_one');
        $operation_description = get_option('dwr_operation_description');

        $signature_value = md5($merchant_login . ":" . $amount . ":" . $transaction_id . ":" . $merchant_pass_one);

        // TODO: Display payment info for user

        $form .= '<div>';
        $form .= '<div>' . __('amount', DWR_PLUGIN_NAME) . ': <strong>' . $amount . '</strong></div>';
        $form .= '<div>' . __('currency', DWR_PLUGIN_NAME) . ': <strong>' . $currency . '</strong></div>';
        $form .= '</div>';

        $form .= '<form action="' . DWR_ROBOKASSA_ACTION_URL . '" method="GET">';
        $form .= '<input type="hidden" name="MrchLogin" value="' . $merchant_login . '" />';
        $form .= '<input type="hidden" name="OutSum" value="' . $amount . '" />';
        $form .= '<input type="hidden" name="InvId" value="' . $transaction_id . '" />';
        $form .= '<input type="hidden" name="Desc" value="' . $operation_description . '" />';
        $form .= '<input type="hidden" name="IncCurrLabel" value="' . $currency . '" />';
        $form .= '<input type="hidden" name="Culture" value="ru" />'; // TODO: think about it
        $form .= '<input type="hidden" name="Encoding" value="utf-8" />';
        $form .= '<input type="hidden" name="SignatureValue" value="' . $signature_value . '" />';
        $form .= '<input type="submit" value="' . __('donate', DWR_PLUGIN_NAME) . '" />';
        $form .= '<input type="button" value="' . __('cancel', DWR_PLUGIN_NAME) . '" />';
        $form .= '</form>';
    }

    return $form;
}

########################
### OPTIONS ### START ##
########################


/**
 * Add plugin menu item in admin panel
 */
function dwr_add_options_page()
{
    add_options_page(
        __('dwr_plugin_page', DWR_PLUGIN_NAME),
        __('dwr_plugin_menu_title', DWR_PLUGIN_NAME),
        'manage_options',
        DWR_PLUGIN_NAME,
        'dwr_plugin_options_page'
    );
//    add_options_page('Custom Plugin Page', 'Custom Plugin Menu', 'manage_options', DWR_PLUGIN_NAME, 'dwr_plugin_options_page');
}

/**
 * Display the admin options page
 */
function dwr_plugin_options_page()
{
    echo "<div>";
    echo "<h2>" . __('dwr_plugin_page_title', DWR_PLUGIN_NAME) . "</h2>";
    echo '<form action="options.php" method="POST">';

    settings_fields('dwr_plugin_options');
    do_settings_sections(DWR_PLUGIN_NAME);

    echo '<input name="' . __('submit', DWR_PLUGIN_NAME) . '" type="submit" value="' . __('save', DWR_PLUGIN_NAME) . '" />';
    echo '</form></div>';

}

function dwr_plugin_options_validator()
{

}

function display_plugin_text()
{
    echo '<p>Main description of this section here.</p>'; // TODO: localization
}

function display_plugin_setting_string()
{
    $options = get_option('plugin_options');
    echo "<input id='dwr_plugin_text_string' name='dwr_plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}

########################
### OPTIONS ### END ####
########################

function process_robokassa()
{

}

function dwr_activate_plugin()
{
    global $wpdb;

    $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

    $sql =
        "
            CREATE TABLE IF NOT EXISTS `" . $table_donations . "` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `amount` FLOAT UNSIGNED NOT NULL,
                `currency` VARCHAR(10) NOT NULL,
                `start_date` DATETIME NOT NULL,
                `finish_date` DATETIME DEFAULT NULL,
                `accomplished` BOOL NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";

    $sql_result = $wpdb->query($sql);

    if ($sql_result === false) {
        error_log("Could not create required tables. SQL: " . $sql);
    }

    add_option('dwr_result_url', 'robokassa_result');
    add_option('dwr_result_url_method', 'POST');
    add_option('dwr_confirm_page_url', '');
    add_option('dwr_merchant_login', '');
    add_option('dwr_text_before_donate_form', '');
    add_option('dwr_operation_description', '');
    add_option('dwr_merchant_pass_one', '');
    add_option('dwr_merchant_pass_two', '');
}

function dwr_deactivate_plugin()
{
    global $wpdb;

    $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

    $sql = "DROP TABLE `" . $table_donations . "`";

    $wpdb->query($sql);

    delete_option('dwr_result_url');
    delete_option('dwr_result_url_method');
    delete_option('dwr_confirm_page_url');
    delete_option('dwr_merchant_login');
    delete_option('dwr_text_before_donate_form');
    delete_option('dwr_operation_description');
    delete_option('dwr_merchant_pass_one');
    delete_option('dwr_merchant_pass_two');
}

register_activation_hook( __FILE__, 'dwr_activate_plugin');
register_deactivation_hook( __FILE__, 'dwr_deactivate_plugin');

add_action('init', 'init_plugin');
add_action('admin_init', 'admin_init_plugin');

add_shortcode('dwr_donate_form', 'dwr_donate_form_shortcode');
add_shortcode('dwr_confirm_form', 'dwr_confirm_form_shortcode');

### OPTIONS
add_action('admin_menu', 'dwr_add_options_page');
### OPTIONS
