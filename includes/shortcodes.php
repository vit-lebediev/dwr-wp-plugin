<?php
/**
 * This shortcode displays robokassa payment widget with a field for arbitrary amount of donation, payment button and
 * Robokassa wording.
 *
 * Applicable parameters:
 *  'compact' - display compact payment button with a wording under it, without field for arbitrary amount of donation
 *
 * @param $attributes
 * @return string
 */
function dwr_payment_widget_shortcode($attributes)
{
    $compact_mode = false;

    if (is_array($attributes)) {
        foreach ($attributes as $attribute) {
            switch ($attribute) {
                case 'compact';
                    $compact_mode = true;
                    break;
            }
        }
    }

    // display widget with default amount
    $merchant_login = get_option('dwr_merchant_login');

    $widget = '';

    if (!dwr_required_fields_are_set()) {
        $widget = __('not_all_settings_are_set', DWR_PLUGIN_NAME);
    } else {
        $merchant_pass_one = get_option('dwr_merchant_pass_one');
        $operation_description = get_option('dwr_operation_description');
        $default_donation_amount = get_option('dwr_default_donation_amount');
        $inv_id = 0; // default so that robokassa could assing it's own value for this

        if ($compact_mode) {
            $signature_value = md5($merchant_login . ":" . $default_donation_amount . ":" . $inv_id . ":" . $merchant_pass_one);

            $widget .= '<script language="javascript" src="https://auth.robokassa.ru/Merchant/PaymentForm/FormV.js?MerchantLogin=' . $merchant_login . '&OutSum=' . $default_donation_amount . '&InvoiceID=' . $inv_id . '&Description=' . $operation_description . '&SignatureValue=' . $signature_value . '"></script>';
        } else {
            $signature_value = md5($merchant_login . "::" . $inv_id . ":" . $merchant_pass_one);

            $widget .= '<script language="javascript" src="https://auth.robokassa.ru/Merchant/PaymentForm/FormFL.js?MerchantLogin=' . $merchant_login . '&DefaultSum=' . $default_donation_amount . '&InvoiceID=' . $inv_id . '&Description=' . $operation_description . '&SignatureValue=' . $signature_value . '"></script>';
        }

    }

    return $widget;
}
