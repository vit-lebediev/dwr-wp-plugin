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

/**
 * Define MySQL constants
 */
define('DWR_DONATIONS_TABLE_NAME', 'dwr_donations');

/**
 * Define URL constants
 */
define('DWR_ROBOKASSA_ACTION_URL', 'http://test.robokassa.ru/Index.aspx');
define('DWR_ROBOKASSA_GET_CURRENCIES_URL', 'http://test.robokassa.ru/Webservice/Service.asmx/GetCurrencies');

/**
 * Define other constants
 */
define('DWR_PLUGIN_NAME', 'donate-with-robokassa');

include realpath(dirname(__FILE__)) . '/includes/activation.php';
include realpath(dirname(__FILE__)) . '/includes/initialization.php';
include realpath(dirname(__FILE__)) . '/includes/shortcodes.php';
include realpath(dirname(__FILE__)) . '/includes/options.php';

function process_robokassa()
{

}

/**
 * Activation
 */
register_activation_hook( __FILE__, 'dwr_activate_plugin');
register_deactivation_hook( __FILE__, 'dwr_deactivate_plugin');

/**
 * Initialization
 */
add_action('init', 'init_plugin');
add_action('admin_init', 'admin_init_plugin');

/**
 * Shortcodes
 */
add_shortcode('dwr_donate_form', 'dwr_donate_form_shortcode');
add_shortcode('dwr_confirm_form', 'dwr_confirm_form_shortcode');

/**
 * Options
 */
add_action('admin_menu', 'dwr_add_options_page');
