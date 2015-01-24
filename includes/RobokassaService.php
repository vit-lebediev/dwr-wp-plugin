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

//        echo "Merchant login: '" . $this->merchantLogin . "'";
//        echo "Language: " . $this->responseLanguage;
//
//        $merchantLoginParam = new \SoapParam($this->merchantLogin, 'MerchantLogin');
//        $languageParam = new \SoapParam($this->responseLanguage, 'Language');
//
//        echo '<pre>';
//        print_r($merchantLoginParam);
//        print_r($languageParam);
//        echo '</pre>';
//
//        $result = $this->soapClient->GetCurrencies(
//            $merchantLoginParam,
//            $merchantLoginParam,
//            $languageParam
//        );
//        echo '<pre>';
//        print_r($result);
//        print_r($this->soapClient->__getLastRequestHeaders());
//        echo "<hr>";
//        print_r(htmlentities($this->soapClient->__getLastRequest()));
//        echo "<hr>";
//        print_r($this->soapClient->__getLastResponseHeaders());
//        echo "<hr>";
//        print_r(htmlentities($this->soapClient->__getLastResponse()));
//        echo '</pre>';
//        echo "<hr>";
//        if (is_object($result) && $result->GetCurrenciesResult->Result->Code != 0) {
//            echo "Error occured while requesting available merchant currencies: " . $result->GetCurrenciesResult->Result->Description;
//        } else {
//            return new \SimpleXMLElement($result);
//        }
    }

    private $merchantLogin = null;
    private $responseLanguage = null;
}
