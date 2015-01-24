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
