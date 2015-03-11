<?php
/**
 * Plugin Name: Donate With Robokassa (DWR)
 * Plugin URI: https://github.com/Malgin/dwr-wp-plugin
 * Description:
 *     A plugin which will help you integrate robokassa into your website to accept donations.
 * 
 * Version: 1.0.3
 * Author: Malgin
 * Author URI: https://github.com/Malgin
 * License: MIT
**/

/**
 * Define MySQL constants
 */
define('DWR_DONATIONS_TABLE_NAME', 'dwr_donations');

/**
 * Define other constants
 */
define('DWR_PLUGIN_NAME', 'donate-with-robokassa');

include realpath(dirname(__FILE__)) . '/includes/styles.php';
include realpath(dirname(__FILE__)) . '/includes/scripts.php';

include realpath(dirname(__FILE__)) . '/includes/utils.php';

include realpath(dirname(__FILE__)) . '/includes/activation.php';
include realpath(dirname(__FILE__)) . '/includes/initialization.php';
include realpath(dirname(__FILE__)) . '/includes/shortcodes.php';
include realpath(dirname(__FILE__)) . '/includes/options.php';
include realpath(dirname(__FILE__)) . '/includes/DWRRobokassaService.php';

/**
 * Activation
 */
register_activation_hook( __FILE__, 'dwr_activate_plugin');
register_deactivation_hook( __FILE__, 'dwr_deactivate_plugin');

/**
 * Initialization
 */
add_action('init', 'init_plugin');

/**
 * Shortcodes
 */
add_shortcode('dwr_payment_widget', 'dwr_payment_widget_shortcode');

/**
 * Filters
 */
add_filter('widget_text', 'do_shortcode'); // enable shortcodes in widgets

/**
 * Scripts
 */
add_action('wp_enqueue_scripts', 'dwr_enqueue_styles');
//add_action('wp_enqueue_scripts', 'dwr_enqueue_scripts');

if (is_admin()) {
    add_action('admin_enqueue_scripts', 'dwr_enqueue_admin_styles');

    /**
     * Initialization
     */
    add_action('admin_init', 'dwr_admin_init_plugin');

    /**
     * Options
     */
    add_action('admin_menu', 'dwr_add_options_page');
}
