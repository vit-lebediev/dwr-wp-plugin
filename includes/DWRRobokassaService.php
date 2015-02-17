<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 24.01.15
 * Time: 3:15
 */

/**
 * Class DWRRobokassaService
 *
 * Use to access robokassa data
 */
class DWRRobokassaService
{
    public function __construct($merchantLogin, $responseLanguage)
    {
        $this->merchantLogin = $merchantLogin;
        $this->responseLanguage = $responseLanguage;
    }

    public function getAvailableCurrencies()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, DWR_ROBOKASSA_GET_CURRENCIES_URL . '?MerchantLogin=' . $this->merchantLogin . '&Language=' . $this->responseLanguage);

        $result = curl_exec($curl);

        curl_close($curl);

        if ((is_object($result) AND $result->GetCurrenciesResult->Result->Code != 0) OR !$result) {
            error_log("Error occured while requesting available merchant currencies: " . $result->GetCurrenciesResult->Result->Description);
            return false;
        } else {
            return new \SimpleXMLElement($result);
        }
    }

    public function processResult($invId, $outSum, $signatureValue)
    {
        global $wpdb;

        if (!$invId OR !$outSum OR !$signatureValue) {
            error_log("No invId, outSum or signatureValue provided.");
            error_log("invId: $invId, outSum: $outSum, signatureValue: $signatureValue");
            die("No invId, outSum or signatureValue provided.");
        }

        $merchant_pass_two = get_option('dwr_merchant_pass_two');
        $default_donation_amount = get_option('dwr_default_donation_amount');

        if (!$merchant_pass_two) {
            error_log("Merchant Pass #2 is not set in admin panel.");
            die("Internal error");
        }

        $mySignatureValue = strtolower(md5("$default_donation_amount:$invId:$merchant_pass_two"));
        $signatureValue = strtolower($signatureValue);

        if ($signatureValue === $mySignatureValue) {
            echo "OK$invId";
            // TODO: implement mail delivery if required
            // wp_mail("malgin05@gmail.com", "Domation arrived", "Details");

            // create new donation entry in the DB
            dwr_create_donation_entry($outSum, $invId);
        } else {
            error_log("Signatures don't match, something went wrong. Their: $signatureValue, ours: $mySignatureValue");
            echo "Signatures don't match, something went wrong.";
        }

        exit();
    }

    private $merchantLogin = null;
    private $responseLanguage = null;
}
