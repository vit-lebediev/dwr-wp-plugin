<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 23.01.15
 * Time: 17:52
 */

function dwr_activate_plugin()
{
    global $wpdb;

    $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

    $sql =
        "
            CREATE TABLE IF NOT EXISTS `" . $table_donations . "` (
                `id` INT(11) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
                `robokassa_id` INT(11) UNSIGNED UNIQUE DEFAULT NULL,
                `amount` FLOAT UNSIGNED NOT NULL,
                `donation_date` DATETIME NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";

    $sql_result = $wpdb->query($sql);

    if ($sql_result === false) {
        error_log("Could not create required tables. SQL: " . $sql);
    }

    add_option('dwr_result_url', 'robokassa_result');
    add_option('dwr_result_url_method', 'POST');

    add_option('dwr_merchant_login', '');
    add_option('dwr_merchant_pass_one', '');
    add_option('dwr_merchant_pass_two', '');

    add_option('dwr_default_donation_amount');
    add_option('dwr_operation_description', '');

    add_option('dwr_force_delete_tables', '');
}

function dwr_deactivate_plugin()
{
    global $wpdb;

    $forceDeleteTables = get_option('dwr_force_delete_tables');

    if ($forceDeleteTables) {
        $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

        $sql = "DROP TABLE `" . $table_donations . "`";

        $wpdb->query($sql);
    }

    delete_option('dwr_result_url');
    delete_option('dwr_result_url_method');

    delete_option('dwr_merchant_login');
    delete_option('dwr_merchant_pass_one');
    delete_option('dwr_merchant_pass_two');

    delete_option('dwr_default_donation_amount');
    delete_option('dwr_operation_description');

    delete_option('dwr_force_delete_tables');
}
