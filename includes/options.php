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

    add_options_page(
        __('dwr_plugin_statistics_page', DWR_PLUGIN_NAME),
        __('dwr_plugin_statistics_menu_title', DWR_PLUGIN_NAME),
        'manage_options',
        DWR_PLUGIN_NAME . '-statistics',
        'display_plugin_statistics_page'
    );
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

    $dwr_confirm_page_url = get_option('dwr_confirm_page_url');

    $dwr_result_url = get_option('dwr_result_url');
    $dwr_result_url_method = get_option('dwr_result_url_method');

    $dwr_merchant_login = get_option('dwr_merchant_login');
    $dwr_merchant_pass_one = get_option('dwr_merchant_pass_one');
    $dwr_merchant_pass_two = get_option('dwr_merchant_pass_two');

    $dwr_text_before_donate_form = get_option('dwr_text_before_donate_form');
    $dwr_operation_description = get_option('dwr_operation_description');

    $dwr_force_delete_tables = (int)get_option('dwr_force_delete_tables');

    echo "<table><tr>";
    echo "  <td>" . __('confirm_page_url', DWR_PLUGIN_NAME) . "&nbsp;<span class='dwr_required'>*</span></td><td><input name='dwr_confirm_page_url' size='40' type='text' value='" . $dwr_confirm_page_url .  "' /></td>";
    echo "</tr><tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td>";

    echo "</tr><tr>";
    echo "  <td>" . __('result_url', DWR_PLUGIN_NAME) . "&nbsp;<span class='dwr_required'>*</span></td><td><input name='dwr_result_url' size='40' type='text' value='" . $dwr_result_url . "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('result_url_method', DWR_PLUGIN_NAME) . "&nbsp;<span class='dwr_required'>*</span></td><td>";
    echo "<select name='dwr_result_url_method'>";
    echo "  <option value='POST' " . selected($dwr_result_url_method, 'POST', false) . ">POST</option>";
    echo "  <option value='GET' " . selected($dwr_result_url_method, 'GET', false) . ">GET</option>";
    echo "</select>";
    echo "</td></tr><tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td>";

    echo "</tr><tr>";
    echo "  <td>" . __('merchant_login', DWR_PLUGIN_NAME) . "&nbsp;<span class='dwr_required'>*</span></td><td><input name='dwr_merchant_login' size='40' type='text' value='" . $dwr_merchant_login .  "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('merchant_pass_one', DWR_PLUGIN_NAME) . "&nbsp;<span class='dwr_required'>*</span></td><td><input name='dwr_merchant_pass_one' size='40' type='text' value='" . $dwr_merchant_pass_one .  "' /></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('merchant_pass_two', DWR_PLUGIN_NAME) . "&nbsp;<span class='dwr_required'>*</span></td><td><input name='dwr_merchant_pass_two' size='40' type='text' value='" . $dwr_merchant_pass_two .  "' /></td>";
    echo "</tr><tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td>";

    echo "</tr><tr>";
    echo "  <td>" . __('text_before_donate_form', DWR_PLUGIN_NAME) . "</td><td><textarea name='dwr_text_before_donate_form' maxlength='65536' placeholder='" . __('text_before_donate_form', DWR_PLUGIN_NAME) . "'>" . $dwr_text_before_donate_form .  "</textarea></td>";
    echo "</tr><tr>";
    echo "  <td>" . __('operation_description', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_operation_description' size='40' type='text' value='" . $dwr_operation_description .  "' /></td>";
    echo "</tr><tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td>";

    echo "</tr><tr>";
    echo "  <td>" . __('force_delete_tables', DWR_PLUGIN_NAME) . "</td><td><input name='dwr_force_delete_tables' type='checkbox' value='1' " . checked(1 === $dwr_force_delete_tables) . " /></td>";
    echo "</tr></table>";

    submit_button();
    echo '</form></div>';
}

/**
 * Display the admin options page
 */
function display_plugin_statistics_page() {
    global $wpdb;

    $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

    $total_transactions = $wpdb->get_var("SELECT COUNT(*) FROM $table_donations");

    echo "<div>";
    echo "<h1>" . __('dwr_plugin_statistics_page_title', DWR_PLUGIN_NAME) . "</h1>";
    if ($total_transactions > 0) {
        echo "<h2>" . __("general_statistics", DWR_PLUGIN_NAME) . "</h2>";

        // transactions and total donations amount today
        $transactions_today = $wpdb->get_var("SELECT COUNT(*) FROM $table_donations WHERE DATE(start_date) = DATE(NOW())");
        $amount_today = $wpdb->get_var("SELECT SUM(amount) FROM $table_donations WHERE DATE(start_date) = DATE(NOW())");
        echo "<div class='dwr_statistics_entry'>";
        echo __("transactions_today", DWR_PLUGIN_NAME) . ": $transactions_today";
        echo "<br />";
        echo __("total_donation_amount_today", DWR_PLUGIN_NAME) . ": " . number_format($amount_today, 2);
        echo "</div>";

        // transactions and total donations amount for this 7 days
        $transactions_this_week = $wpdb->get_var("SELECT COUNT(*) FROM $table_donations WHERE WEEKOFYEAR(start_date) = WEEKOFYEAR(NOW())");
        $amount_this_week = $wpdb->get_var("SELECT SUM(amount) FROM $table_donations WHERE WEEKOFYEAR(start_date) = WEEKOFYEAR(NOW())");
        echo "<div class='dwr_statistics_entry'>";
        echo __("transactions_this_week", DWR_PLUGIN_NAME) . ": $transactions_this_week";
        echo "<br />";
        echo __("total_donation_amount_this_week", DWR_PLUGIN_NAME) . ": " . number_format($amount_this_week, 2);
        echo "</div>";

        // transactions and total donations amount for this month
        $transactions_this_month = $wpdb->get_var("SELECT COUNT(*) FROM $table_donations WHERE MONTH(start_date) = MONTH(NOW())");
        $amount_this_month = $wpdb->get_var("SELECT SUM(amount) FROM $table_donations WHERE MONTH(start_date) = MONTH(NOW())");
        echo "<div class='dwr_statistics_entry'>";
        echo __("transactions_this_month", DWR_PLUGIN_NAME) . ": $transactions_this_month";
        echo "<br />";
        echo __("total_donation_amount_this_month", DWR_PLUGIN_NAME) . ": " . number_format($amount_this_month, 2);
        echo "</div>";

        // transactions and total donations amount for this year
        $transactions_this_year = $wpdb->get_var("SELECT COUNT(*) FROM $table_donations WHERE YEAR(start_date) = YEAR(NOW())");
        $amount_this_year = $wpdb->get_var("SELECT SUM(amount) FROM $table_donations WHERE YEAR(start_date) = YEAR(NOW())");
        echo "<div class='dwr_statistics_entry'>";
        echo __("transactions_this_year", DWR_PLUGIN_NAME) . ": $transactions_this_year";
        echo "<br />";
        echo __("total_donation_amount_this_year", DWR_PLUGIN_NAME) . ": " . number_format($amount_this_year, 2);
        echo "</div>";

        $total_amount = $wpdb->get_var("SELECT SUM(amount) FROM $table_donations");
        echo "<div class='dwr_statistics_entry'>";
        echo __("transactions_total", DWR_PLUGIN_NAME) . ": $total_transactions";
        echo "<br />";
        echo __("total_donation_amount", DWR_PLUGIN_NAME) . ": " . number_format($total_amount, 2);
        echo "</div>";

        $last100transactions = $wpdb->get_results("SELECT * FROM `" . $table_donations . "` ORDER BY start_date DESC LIMIT 100");

        echo "<h2>" . __("last_hundred_transactions_detailed", DWR_PLUGIN_NAME) . "</h2>";
        echo "<table class='dwr_transactions_table'>";
        echo "<tr>";
        echo "<th class='dwr_id_col'>" . __("transaction_id", DWR_PLUGIN_NAME) . "</th><th class='dwr_sum_col'>" . __("donation_sum", DWR_PLUGIN_NAME) . "</th><th class='dwr_payment_col'>" . __("payment_method", DWR_PLUGIN_NAME) . "</th><th class='dwr_date_col'>" . __("transaction_date", DWR_PLUGIN_NAME) . "</th><th class='dwr_message_col'>" . __("transaction_user_message", DWR_PLUGIN_NAME) . "</th>";
        echo "</tr>";
        foreach ($last100transactions as $transaction) {
            echo "<tr class='" . (($transaction->accomplished) ? 'transaction_accomplished' : 'transaction_not_accomplished') . "'>";
            echo "<td class='dwr_id_col'>{$transaction->id}</td><td class='dwr_sum_col'>{$transaction->amount}</td><td class='dwr_payment_col'>{$transaction->currencyName}</td><td class='dwr_date_col'>" . date('F j, Y, g:i a', strtotime($transaction->start_date)) . "</td><td class='dwr_message_col'>{$transaction->message}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        _e("no_transactions_yet_been_performed");
    }

    echo "</div>";
}
