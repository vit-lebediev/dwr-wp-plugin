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
    const ROBOKASSA_WSDL_URL = 'http://test.robokassa.ru/Webservice/Service.asmx?WSDL';

    public function __construct($merchantLogin, $responseLanguage)
    {
        $this->soapClient = new \SoapClient(self::ROBOKASSA_WSDL_URL, array('trace' => true));
        $this->merchantLogin = $merchantLogin;
        $this->responseLanguage = $responseLanguage;
    }

    public function getAvailableCurrencies()
    {
        echo "Merchant login: '" . $this->merchantLogin . "'";
        echo "Language: " . $this->responseLanguage;

        $merchantLoginParam = new \SoapParam($this->merchantLogin, 'MerchantLogin');
        $languageParam = new \SoapParam($this->responseLanguage, 'Language');

        echo '<pre>';
        print_r($merchantLoginParam);
        print_r($languageParam);
        echo '</pre>';

        $result = $this->soapClient->GetCurrencies(
            $merchantLoginParam,
            $merchantLoginParam,
            $languageParam
        );
        echo '<pre>';
        print_r($result);
        print_r($this->soapClient->__getLastRequestHeaders());
        echo "<hr>";
        print_r(htmlentities($this->soapClient->__getLastRequest()));
        echo "<hr>";
        print_r($this->soapClient->__getLastResponseHeaders());
        echo "<hr>";
        print_r(htmlentities($this->soapClient->__getLastResponse()));
        echo '</pre>';
        echo "<hr>";
        if (is_object($result) && $result->GetCurrenciesResult->Result->Code != 0) {
            echo "Error occured while requesting available merchant currencies: " . $result->GetCurrenciesResult->Result->Description;
        } else {
            return new \SimpleXMLElement($result);
        }
    }

    private $soapClient = null;
    private $merchantLogin = null;
    private $responseLanguage = null;
}
