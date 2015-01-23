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

    echo "<input name='dwr_result_url' size='40' type='text' value='" . $dwr_result_url . "' />";
    echo "<input name='dwr_result_url_method' size='40' type='text' value='" . $dwr_result_url_method .  "' />";

    submit_button();
    echo '</form></div>';

}
