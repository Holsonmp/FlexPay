<?php

/**
 * FlexPay Payment Gateway Module for WHMCS
 *
 * @author Holsonmp
 * @link https://github.com/holsonmp/flexpay
 * @license GNU GPL 2.0
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

/**
 * Define module related meta data.
 *
 * Values returned here are used to determine module related capabilities and
 * settings.
 *
 * @see https://developers.whmcs.com/payment-gateways/meta-data-params/
 *
 * @return array
 */

function flexpay_MetaData()
{
    return array(
        'DisplayName' => 'FlexPay',
        'APIVersion' => '1.1', // Use API Version 1.1
        'DisableLocalCredtCardInput' => true,
        'TokenisedStorage' => false,
    );
}
/**
 * Define gateway configuration options.
 *
 * The fields you define here determine the configuration options that are
 * presented to administrator users when activating and configuring your
 * payment gateway module for use.
 *
 * Supported field types include:
 * * text
 * * password
 * * yesno
 * * dropdown
 * * radio
 * * textarea
 *
 * Examples of each field type and their possible configuration parameters are
 * provided in the sample function below.
 *
 * @return array
 */
function flexpay_config()
{
    return [
        'FriendlyName' => [
            'Type' => 'System',
            'Value' => 'FlexPay Gateway (Mobile Money, Visa,MasterCard)',
        ],
        'merchant' => [
            'FriendlyName' => 'Merchant Code',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Votre identifiant marchand fourni par FlexPay',
        ],
        'secretKey' => [
            'FriendlyName' => 'API Token',
            'Type' => 'password',
            'Size' => '50',
            'Default' => '',
            'Description' => 'Token d\'authentification pour l\'API FlexPay',
        ],
        'testMode' => [
            'FriendlyName' => 'Mode Test',
            'Type' => 'yesno',
            'Description' => 'Cocher pour activer le mode test',
        ],
    ];
}

/**
 * Payment link.
 */
function flexpay_link($params)
{
    // Gateway Configuration Parameters
    $merchant = $params['merchant'];
    $secretKey = $params['secretKey'];
    $testMode = $params['testMode'];

    // Invoice Parameters
    $invoiceId = $params['invoiceid'];
    $description = $params["description"];
    $amount = $params['amount'];
    $currencyCode = $params['currency'];
    

    // Client Parameters
    $firstname = $params['clientdetails']['firstname'];
    $lastname = $params['clientdetails']['lastname'];
    $email = $params['clientdetails']['email'];
    $phone = $params['clientdetails']['phonenumber'];
    $city = $params['clientdetails']['city'];
    $state = $params['clientdetails']['state'];
    $postcode = $params['clientdetails']['postcode'];
    $country = $params['clientdetails']['country'];

    // System Parameters
    $systemUrl = $params['systemurl'];
    $returnUrl = $params['returnurl'];
        // System Parameters
    $companyName = $params['companyname'];
    $systemUrl = $params['systemurl'];
    $returnUrl = $params['returnurl'];
    $langPayNow = $params['langpaynow'];
    $moduleDisplayName = $params['name'];
    $moduleName = $params['paymentmethod'];
    $whmcsVersion = $params['whmcsVersion'];
	

    // Determine the API URL based on test mode
    $url = $testMode ? 'https://beta-cardpayment.flexpay.cd/v3/pay?authorization=' . $secretKey : 'https://cardpayment.flexpay.cd/v3/pay?authorization=' . $secretKey;

    // Prepare the form fields
    $formFields = array(
        'PayType' => 'FLEXPAY',
        'merchant' => $merchant,
        'reference' => $invoiceId,
        'amount' => $amount,
        'currency' => $currencyCode,
        'description' => urlencode($description),
        'callback_url' => urlencode($systemUrl . '/modules/gateways/callback/'. $moduleName . '.php'),
        'approve_url' => urlencode($returnUrl),
        'cancel_url' => urlencode($returnUrl),
        'decline_url' => urlencode($returnUrl),
        'home_url' => urlencode($returnUrl),
        'trans_code' => $invoiceId,
        'trans_description' => urlencode($description),
        'trans_amount' => $amount,
        'trans_currency' => $currencyCode,
        'first_name' => $firstname,
        'last_name' => $lastname,
        'customer_email' => urlencode($email),
        'city' => $city,
        'state' => $state,
        'postcode' => $postcode,
        'country' => $country,
        'customer_phone' => $phone,
        'url_back' => urlencode($returnUrl),
        'app_code' => $merchant,
        'merchant_code' => $secretKey,
        'display' => '1',
        'redirection' => '1'
    );

    // Build the form HTML
    $htmlOutput = '<form method="post" action="' . $url . '&merchant=' . $merchant . '&reference=' . $invoiceId . '&amount=' . $amount . '&currency=' . $currencyCode . '&description=' . urlencode($description) . '&callback_url=' . urlencode($systemUrl . '/modules/gateways/callback/flexpay.php') . '&approve_url=' . urlencode($returnUrl) . '&cancel_url=' . urlencode($returnUrl) . '&decline_url=' . urlencode($returnUrl) . '&home_url=' . urlencode($returnUrl) . '">';

    foreach ($formFields as $k => $v) {
        $htmlOutput .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
    }

    $htmlOutput .= '<input type="submit" value="Payer maintenant" style="padding: 5px 10px;font-size: 14px;background-color: #428bca;color: #fff;border-color: #357ebd;" />';
    $htmlOutput .= '</form>';

    return $htmlOutput;
}

/**
 * Refund transaction.
 */
function flexpay_refund($params)
{
    // Gateway Configuration Parameters
    $merchant = $params['merchant'];
    $secretKey = $params['secretKey'];
    $testMode = $params['testMode'];

    // Transaction Parameters
    $transactionIdToRefund = $params['transid'];
    $refundAmount = $params['amount'];
    $currencyCode = $params['currency'];

    // Perform API call to initiate refund and interpret result
    // This is a placeholder for the actual API call
    $responseData = array(); // Replace with actual API response
    $refundTransactionId = ''; // Replace with actual transaction ID
    $feeAmount = 0; // Replace with actual fee amount

    return array(
        'status' => 'success',
        'rawdata' => $responseData,
        'transid' => $refundTransactionId,
        'fees' => $feeAmount,
    );
}

/**
 * Cancel subscription.
 */
function flexpay_cancelSubscription($params)
{
    // Gateway Configuration Parameters
    $merchant = $params['merchant'];
    $secretKey = $params['secretKey'];
    $testMode = $params['testMode'];

    // Subscription Parameters
    $subscriptionIdToCancel = $params['subscriptionID'];

    // Perform API call to cancel subscription and interpret result
    // This is a placeholder for the actual API call
    $responseData = array(); // Replace with actual API response

    return array(
        'status' => 'success',
        'rawdata' => $responseData,
    );
}
