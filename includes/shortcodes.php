<?php
/**
 * This shortcode displays donation form, and should be placed on donation page or in some widget
 *
 * @param $attr
 * @return string
 */

function dwr_donate_form_shortcode()
{
    // form generated right here
    $form = '';

    $confirmation_page_url = get_option('dwr_confirm_page_url');
    $merchant_login = get_option('dwr_merchant_login');

    if (!$confirmation_page_url OR !$merchant_login) {
        $form = __('cannot_operate', DWR_PLUGIN_NAME); // "Not all required fields are filled in admin panel. This plugin cannot operate."
    } else {
        // Load currencies from robokassa
        $robokassaService = new RobokassaService($merchant_login, 'ru'); // TODO replace language with dynamic var
        if (!$currenciesListAsXML = $robokassaService->getAvailableCurrencies()) {
            $form .= __('error_during_currency_request', DWR_PLUGIN_NAME); // "Error occured during request for available currencies. Please contact website administration."
        } else {
            $action_url = "/" . $confirmation_page_url;

            $form .= '<div>' . __(get_option('dwr_text_before_donate_form'), DWR_PLUGIN_NAME) . '</div>';

            $form .= '<form action="' . $action_url . '" method="GET">';
            $form .= '<input type="text" name="OutSum" />';
            $form .= '<select name="IncCurrLabel">';

            foreach ($currenciesListAsXML->Groups->Group as $group) {
                $form .= '<option disabled>' . $group['Description'] . '</option>';
                foreach ($group->Items->Currency as $currency)
                {
                    $form .= '<option value="' . $currency['Label'] . '">&nbsp;&nbsp;&nbsp;' . $currency['Name'] . '</option>';
                }
            }

            $form .= '</select>';
            $form .= '<input type="submit" value="' . __('donate', DWR_PLUGIN_NAME) . '" />';
            $form .= '</form>';
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
    global $wpdb;

    $amount = $_GET['OutSum'];
    $currency = $_GET['IncCurrLabel'];

    $merchant_login = get_option('dwr_merchant_login');

    $form = '';

    // TODO: check data
    // TODO: check for more than 2 numbers after coma
    // TODO: check if amout is not negative
    if (!$merchant_login) {
        $form = __('cannot_operate', 'donate-with-robokassa'); // Not all required fields are filled in admin panel. This plugin cannot operate.
    } else {
        $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;

        // create a new donate entry in DB
        $wpdb->insert(
            $table_donations,
            array(
                'amount' => $amount,
                'currency' => $currency,
                'start_date' => current_time('mysql', 1),
            ),
            array(
                '%f',
                '%s',
                '%s'
            )
        );

        $transaction_id = $wpdb->insert_id;

        $merchant_pass_one = get_option('dwr_merchant_pass_one');
        $operation_description = get_option('dwr_operation_description');

        $signature_value = md5($merchant_login . ":" . $amount . ":" . $transaction_id . ":" . $merchant_pass_one);

        // TODO: Display payment info for user

        $form .= '<div>';
        $form .= '<div>' . __('amount', DWR_PLUGIN_NAME) . ': <strong>' . $amount . '</strong></div>';
        $form .= '<div>' . __('currency', DWR_PLUGIN_NAME) . ': <strong>' . $currency . '</strong></div>';
        $form .= '</div>';

        $form .= '<form action="' . DWR_ROBOKASSA_ACTION_URL . '" method="POST">';
        $form .= '<input type="hidden" name="MrchLogin" value="' . $merchant_login . '" />';
        $form .= '<input type="hidden" name="OutSum" value="' . $amount . '" />';
        $form .= '<input type="hidden" name="InvId" value="' . $transaction_id . '" />';
        $form .= '<input type="hidden" name="Desc" value="' . $operation_description . '" />';
        $form .= '<input type="hidden" name="IncCurrLabel" value="' . $currency . '" />';
        $form .= '<input type="hidden" name="Culture" value="ru" />'; // TODO: think about it
        $form .= '<input type="hidden" name="Encoding" value="utf-8" />';
        $form .= '<input type="hidden" name="SignatureValue" value="' . $signature_value . '" />';
        $form .= '<input type="submit" value="' . __('donate', DWR_PLUGIN_NAME) . '" />';
        $form .= '<input type="button" value="' . __('cancel', DWR_PLUGIN_NAME) . '" />';
        $form .= '</form>';
    }

    return $form;
}
