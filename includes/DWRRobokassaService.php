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
    public function __construct($merchantLogin)
    {
        $this->merchantLogin = $merchantLogin;
    }

    public function processResult($invId, $outSum, $signatureValue)
    {
        if (!$invId OR !$outSum OR !$signatureValue) {
            error_log("No invId, outSum or signatureValue provided.");
            error_log("invId: $invId, outSum: $outSum, signatureValue: $signatureValue");
            die("No invId, outSum or signatureValue provided.");
        }

        $merchant_pass_two = get_option('dwr_merchant_pass_two');

        if (!$merchant_pass_two) {
            error_log("Merchant Pass #2 is not set in admin panel.");
            die("Internal error");
        }

        $mySignatureValue = strtolower(md5("$outSum:$invId:$merchant_pass_two"));
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
}
