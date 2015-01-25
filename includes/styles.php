<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 25.01.15
 * Time: 20:11
 */

function dwr_enqueue_styles()
{
    wp_enqueue_style('dwr-styles', plugins_url('css/front.css', __FILE__));
}

function dwr_enqueue_admin_styles()
{
    wp_enqueue_style('dwr-styles', plugins_url('css/admin.css', __FILE__));
}
