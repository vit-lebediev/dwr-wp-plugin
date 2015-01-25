<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 24.01.15
 * Time: 19:18
 */

function dwr_get_blog_language_for_robokassa()
{
    $culture = substr(get_bloginfo("language"), 0, 2);
    $allowed_cultures = array('ru', 'en');

    if (!in_array($culture, $allowed_cultures)) {
        $culture = 'ru';
    }

    return $culture;
}

function dwr_required_fields_are_set() {
    $confirmation_page_url = get_option('dwr_confirm_page_url');
    $merchant_login = get_option('dwr_merchant_login');
    $merchant_pass_one = get_option('dwr_merchant_pass_one');
    $merchant_pass_two = get_option('dwr_merchant_pass_two');
    $dwr_result_url = get_option('dwr_result_url');
    $dwr_result_url_method = get_option('dwr_result_url_method');

    if ($confirmation_page_url AND
        $merchant_login AND
        $merchant_pass_one AND
        $merchant_pass_two AND
        $dwr_result_url AND
        $dwr_result_url_method)
    {
        return true;
    } else {
        return false;
    }
}
