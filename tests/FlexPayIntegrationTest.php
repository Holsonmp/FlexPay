<?php
use PHPUnit\Framework\TestCase;

class FlexPayIntegrationTest extends TestCase
{
    private $callbackUrl = 'https://whmcs.example.com/modules/gateways/callback/flexpay.php';
    
    public function testSuccessfulPayment()
    {
        // Simuler une requête POST de FlexPay
        $_POST = [
            'code' => '0',
            'reference' => '12345', 
            'orderNumber' => 'TX123456',
            'amount' => '100.00'
        ];
        
        // Capturer la sortie
        ob_start();
        require_once __DIR__ . '/../callback/flexpay.php';
        $output = ob_get_clean();
        
        // Vérifier que le paiement a été traité
        $this->assertEmpty($output);
        
        // Vérifier l'insertion en base de données
        // Note: Nécessite une configuration de base de données de test
        $this->assertDatabaseHas('tblaccounts', [
            'invoiceid' => '12345',
            'transid' => 'TX123456',
            'amount' => '100.00',
            'gateway' => 'flexpay'
        ]);
    }
    
    public function testFailedPayment() 
    {
        $_POST = [
            'code' => '1',
            'reference' => '12345',
            'orderNumber' => 'TX123456', 
            'amount' => '100.00'
        ];
        
        ob_start();
        require_once __DIR__ . '/../callback/flexpay.php';
        $output = ob_get_clean();
        
        $this->assertEmpty($output);
        
        // Vérifier qu'aucun paiement n'a été enregistré
        $this->assertDatabaseMissing('tblaccounts', [
            'invoiceid' => '12345',
            'transid' => 'TX123456'
        ]);
    }
}