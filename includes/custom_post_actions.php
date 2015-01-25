<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 25.01.15
 * Time: 20:57
 */

function dwr_delete_uncompleted_transactions() {
    global $wpdb;

    $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

    $wpdb->query("DELETE FROM $table_donations WHERE accomplished='0'");

    wp_redirect($_POST['return_url']);
}
