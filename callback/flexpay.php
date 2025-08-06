<?php
/**
 * WHMCS FlexPay Payment Callback File
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Chargement WHMCS
require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
require_once __DIR__ . '/../../../includes/invoicefunctions.php';

// Nom du module (ex: flexpay)
$gatewayModuleName = basename(__FILE__, '.php');

// Récupérer la config du module
$gatewayParams = getGatewayVariables($gatewayModuleName);

// Vérifier que le module est actif
if (!$gatewayParams['type']) {
    http_response_code(403);
    echo json_encode(['error' => 'Module not activated']);
    exit;
}

// Lire les données JSON brutes envoyées par FlexPay
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

// Vérification JSON valide
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON payload']);
    exit;
}

// Extraire les champs
$code = $data['code'] ?? null;
$reference = $data['reference'] ?? null;
$providerReference = $data['provider_reference'] ?? null;
$orderNumber = $data['orderNumber'] ?? null;
$amount = $data['amount'] ?? 0;

// Vérifier les champs essentiels
if (!$reference || !$orderNumber || $code === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Log et traitement
$success = $code === "0";
$status = $success ? 'Success' : 'Failed';

logTransaction($gatewayParams['name'], $data, $status);

// Enregistrer le paiement si succès
if ($success) {
    addInvoicePayment(
        $reference,            // Invoice ID
        $orderNumber,          // Transaction ID
        $amount,               // Amount paid
        0,                     // Payment fee
        $gatewayModuleName     // Gateway name
    );
}