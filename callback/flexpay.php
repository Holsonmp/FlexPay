<?php
/**
 * WHMCS FlexPay Payment Callback File
 */

require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
require_once __DIR__ . '/../../../includes/invoicefunctions.php';

// Detect module name from filename.
$gatewayModuleName = basename(__FILE__, '.php');

// Fetch gateway configuration parameters.
$gatewayParams = getGatewayVariables($gatewayModuleName);

// Die if module is not active.
if (!$gatewayParams['type']) {
    die("Module Not Activated");
}

// Retrieve data returned in payment gateway callback
$success = $_POST["code"] == "0";
$invoiceId = $_POST["reference"];
$transactionId = $_POST["orderNumber"];
$paymentAmount = $_POST["amount"];
$paymentFee = 0;

$transactionStatus = $success ? 'Success' : 'Failed';

// Log Transaction
logTransaction($gatewayParams['name'], $_POST, $transactionStatus);

if ($success) {
    // Add Invoice Payment
    addInvoicePayment(
        $invoiceId,
        $transactionId,
        $paymentAmount,
        $paymentFee,
        $gatewayModuleName
    );
}
