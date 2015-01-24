<?php
/**
 * Created by PhpStorm.
 * User: Malgin
 * Date: 24.01.15
 * Time: 3:15
 */

/**
 * Class RobokassaService
 *
 * Use to access robokassa data
 */
class RobokassaService
{
    const ROBOKASSA_GET_CURRENCIES_URL = 'http://test.robokassa.ru/Webservice/Service.asmx/GetCurrencies';

    public function __construct($merchantLogin, $responseLanguage)
    {
        $this->merchantLogin = $merchantLogin;
        $this->responseLanguage = $responseLanguage;
    }

    public function getAvailableCurrencies()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, self::ROBOKASSA_GET_CURRENCIES_URL . '?MerchantLogin=' . $this->merchantLogin . '&Language=' . $this->responseLanguage);

        $result = curl_exec($curl);

        curl_close($curl);

        if (is_object($result) && $result->GetCurrenciesResult->Result->Code != 0) {
            echo "Error occured while requesting available merchant currencies: " . $result->GetCurrenciesResult->Result->Description;
        } else {
            return new \SimpleXMLElement($result);
        }
    }

    public function processResult($invId, $signatureValue)
    {
        global $wpdb;

        if (!$invId OR !$signatureValue) {
            error_log("No $invId or $signatureValue provided.");
            die("No $invId or $signatureValue provided.");
        }

        $table_donations = $wpdb->prefix . DWR_DONATIONS_TABLE_NAME;
        $transaction = $wpdb->get_row($wpdb->prepare("SELECT * FROM `" . $table_donations . "` WHERE `id` = %d", $invId));

        $merchant_pass_two = get_option('dwr_merchant_pass_two');

        if (!$merchant_pass_two) {
            error_log("Merchant Pass #2 is not set in admin panel.");
            die("Internal error");
        }

        $mySignatureValue = strtolower(md5("{$transaction->amount}:$invId:$merchant_pass_two"));
        $signatureValue = strtolower($signatureValue);

        if ($signatureValue === $mySignatureValue) {
            echo "OK$invId";
            // TODO: implement mail delivery if required
            // wp_mail("malgin05@gmail.com", "Domation arrived", "Details");
        } else {
            error_log("Signatures don't match, something went wrong. Their: $signatureValue, ours: $mySignatureValue");
            echo "Signatures don't match, something went wrong.";
        }

        exit();
    }

    private $merchantLogin = null;
    private $responseLanguage = null;
}
