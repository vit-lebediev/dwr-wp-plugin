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

    status_header(200);
    die("All unfinished transactions has been deleted");
    die("Server received '{$_REQUEST['data']}' from your browser.");
}
