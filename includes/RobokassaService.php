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

    private $merchantLogin = null;
    private $responseLanguage = null;
}
