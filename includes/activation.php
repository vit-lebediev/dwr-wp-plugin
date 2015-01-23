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
    add_option('dwr_merchant_pass_one', '');
    add_option('dwr_merchant_pass_two', '');

    add_option('dwr_text_before_donate_form', '');
    add_option('dwr_operation_description', '');
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
