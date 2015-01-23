<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 23.01.15
 * Time: 17:52
 */

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
        'display_plugin_options_page'
    );
//    add_options_page('Custom Plugin Page', 'Custom Plugin Menu', 'manage_options', DWR_PLUGIN_NAME, 'dwr_plugin_options_page');
}

/**
 * Display the admin options page
 */
function display_plugin_options_page()
{
    echo "<div>";
    echo "<h2>" . __('dwr_plugin_page_title', DWR_PLUGIN_NAME) . "</h2>";

    echo '<form action="options.php" method="POST">';

    settings_fields('dwr_plugin_options');
    do_settings_sections(DWR_PLUGIN_NAME);

    $dwr_result_url = get_option('dwr_result_url');
    $dwr_result_url_method = get_option('dwr_result_url_method');
    $dwr_confirm_page_url = get_option('dwr_confirm_page_url');

    $dwr_merchant_login = get_option('dwr_merchant_login');
    $dwr_merchant_pass_one = get_option('dwr_merchant_pass_one');
    $dwr_merchant_pass_two = get_option('dwr_merchant_pass_two');

    $dwr_text_before_donate_form = get_option('dwr_text_before_donate_form');
    $dwr_operation_description = get_option('dwr_operation_description');

    echo "<table><tr>";
    echo "  <td>" . __('result_url', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_result_url' size='40' type='text' value='" . $dwr_result_url . "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('result_url_method', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_result_url_method' size='40' type='text' value='" . $dwr_result_url_method .  "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('confirm_page_url', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_confirm_page_url' size='40' type='text' value='" . $dwr_confirm_page_url .  "' /></td>";
    echo "</tr><tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td>";

    echo "</tr><tr>";
    echo "  <td>" . __('merchant_login', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_merchant_login' size='40' type='text' value='" . $dwr_merchant_login .  "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('merchant_pass_one', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_merchant_pass_one' size='40' type='text' value='" . $dwr_merchant_pass_one .  "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('merchant_pass_two', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_merchant_pass_two' size='40' type='text' value='" . $dwr_merchant_pass_two .  "' /></td>";
    echo "</tr><tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td>";

    echo "</tr><tr>";
    echo "  <td>" . __('text_before_donate_form', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_text_before_donate_form' size='40' type='text' value='" . $dwr_text_before_donate_form .  "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('operation_description', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_operation_description' size='40' type='text' value='" . $dwr_operation_description .  "' /></td>";
    echo "</tr></table>";

    submit_button();
    echo '</form></div>';

}
