<?php
/**
 * This shortcode displays donation form, and should be placed on donation page or in some widget
 *
 * @param $attr
 * @return string
 */

function dwr_donate_form_shortcode($attributes)
{
    $hide_user_message = false;

    if (is_array($attributes)) {
        foreach ($attributes as $attribute) {
            switch ($attribute) {
                case 'hideusermessage';
                    $hide_user_message = true;
                    break;
            }
        }
    }

    $form = '';

    $confirmation_page_url = get_option('dwr_confirm_page_url');
    $merchant_login = get_option('dwr_merchant_login');

    if (!dwr_required_fields_are_set()) {
        $form = __('not_all_settings_are_set', DWR_PLUGIN_NAME);
    } else {
        // Load currencies from robokassa
        $robokassaService = new DWRRobokassaService($merchant_login, dwr_get_blog_language_for_robokassa());
        if (!$currenciesListAsXML = $robokassaService->getAvailableCurrencies()) {
            $form .= __('error_during_currency_request', DWR_PLUGIN_NAME);
        } else {
            $action_url = "/" . $confirmation_page_url;

            $form .= '<div class="dwr_donation_form_wrapper">';

            $form .= '<form action="' . $action_url . '" method="GET" id="dwr_donation_form">';
            $form .= '<table><tr>';
            $form .= '<td>';
            $form .= __('donation_sum', DWR_PLUGIN_NAME);
            $form .= '</td><td>';
            $form .= '<input type="text" name="OutSum" class="dwr_input_outsum" />';
            $form .= '</td></tr><tr><td>';
            $form .= __('donation_currency', DWR_PLUGIN_NAME);
            $form .= '</td><td>';
            $form .= '<select name="IncCurrLabelAndName" class="dwr_select_inccurr">';

            foreach ($currenciesListAsXML->Groups->Group as $group) {
                $form .= '<option disabled>' . $group['Description'] . '</option>';
                foreach ($group->Items->Currency as $currency)
                {
                    $form .= '<option value="' . $currency['Label'] . ':' . $currency['Name'] . '">&nbsp;&nbsp;&nbsp;' . $currency['Name'] . '</option>';
                }
            }

            $form .= '</select>';
            $form .= '</td></tr>';

            if (!$hide_user_message) {
                $form .= '<tr><td>';
                $form .= __('user_message', DWR_PLUGIN_NAME);
                $form .= '</td><td>';
                $form .= '<textarea name="UserMessage" maxlength="65536" form="dwr_donation_form" placeholder="' . __('leave_us_a_message', DWR_PLUGIN_NAME) . '" class="dwr_textarea_usermessage"></textarea>';
                $form .= '</td></tr>';
            }

            $form .= '<tr><td>&nbsp;</td><td>';
            $form .= '<input type="submit" value="' . __('donate', DWR_PLUGIN_NAME) . '" class="dwr_submit" />';
            $form .= '</td></tr></table>';
            $form .= '</form>';
            $form .= '</div>';
        }
    }

    return $form;
}

/**
 * This shortcode displays confirmation page, and should be placed on confirmation page
 *
 * @param $attr
 * @return string
 */
function dwr_confirm_form_shortcode()
{
    $amount = $_GET['OutSum'];
    $currencyLabelAndName = $_GET['IncCurrLabelAndName'];
    $currencyLabel = array_shift(explode(":", $currencyLabelAndName));
    $currencyName = array_pop(explode(":", $currencyLabelAndName));
    $userMessage = $_GET['UserMessage'];

    $merchant_login = get_option('dwr_merchant_login');

    $form = '';

    // TODO: check data
    if (count(explode(":", $currencyLabelAndName)) != 2) {
        $form = __('error_provided_currency_incorrect', DWR_PLUGIN_NAME);
    }
    elseif (!is_numeric($amount)) {
        $form = __('error_amount_should_be_numeric', DWR_PLUGIN_NAME);
    }
    elseif ($amount <= 0) {
        $form = sprintf(__('error_amount_cannot_be_below_zero_you_specified %1$.2f', DWR_PLUGIN_NAME), $amount);
    }
    elseif (!dwr_required_fields_are_set()) {
        $form = __('not_all_settings_are_set', DWR_PLUGIN_NAME);
    } else {
        // At this point all checks has been passed successfully
        $transaction_id = dwr_create_transaction($amount, $currencyLabel, $currencyName, $userMessage);

        $merchant_pass_one = get_option('dwr_merchant_pass_one');
        $operation_description = get_option('dwr_operation_description');

        $signature_value = md5($merchant_login . ":" . $amount . ":" . $transaction_id . ":" . $merchant_pass_one);

        // TODO: Display payment info for user

        $form .= '<div class="dwr_confirmation_form_wrapper">';
        $form .= '<div class="dwr_amount">' . __('amount', DWR_PLUGIN_NAME) . ': <strong>' . $amount . '</strong></div>';
        $form .= '<div class="dwr_currency">' . __('donation_currency', DWR_PLUGIN_NAME) . ': <strong>' . $currencyName . '</strong></div>';
        if ($userMessage) {
            $form .= '<div class="dwr_usermessage">' . __('usermessage', DWR_PLUGIN_NAME) . ': <strong>' . $userMessage . '</strong></div>';
        }

        $form .= '<div class="dwr_confirmation_form">';
        $form .= '<form action="' . DWR_ROBOKASSA_ACTION_URL . '" method="POST">';
        $form .= '<input type="hidden" name="MrchLogin" value="' . $merchant_login . '" />';
        $form .= '<input type="hidden" name="OutSum" value="' . $amount . '" />';
        $form .= '<input type="hidden" name="InvId" value="' . $transaction_id . '" />';
        $form .= '<input type="hidden" name="Desc" value="' . $operation_description . '" />';
        $form .= '<input type="hidden" name="IncCurrLabel" value="' . $currencyLabel . '" />';
        $form .= '<input type="hidden" name="Culture" value="' . dwr_get_blog_language_for_robokassa() . '" />';
        $form .= '<input type="hidden" name="Encoding" value="utf-8" />';
        $form .= '<input type="hidden" name="SignatureValue" value="' . $signature_value . '" />';
        $form .= '<input type="submit" value="' . __('donate', DWR_PLUGIN_NAME) . '" class="dwr_submit_button" />';
        $form .= '<input type="button" value="' . __('cancel', DWR_PLUGIN_NAME) . '" class="dwr_cancel_button" />';
        $form .= '</form>';
        $form .= '</div></div>';
    }

    return $form;
}

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

        $signature_value = md5($merchant_login . "::" . $inv_id . ":" . $merchant_pass_one);

        if ($compact_mode) {
            $widget .= '<script language="javascript" src="https://auth.robokassa.ru/Merchant/PaymentForm/FormV.js?MerchantLogin=' . $merchant_login . '&DefaultSum=' . $default_donation_amount . '&InvoiceID=' . $inv_id . '&Description=' . $operation_description . '&SignatureValue=' . $signature_value . '"></script>';
        } else {
            $widget .= '<script language="javascript" src="https://auth.robokassa.ru/Merchant/PaymentForm/FormFL.js?MerchantLogin=' . $merchant_login . '&DefaultSum=' . $default_donation_amount . '&InvoiceID=' . $inv_id . '&Description=' . $operation_description . '&SignatureValue=' . $signature_value . '"></script>';
        }

    }

    return $widget;
}
