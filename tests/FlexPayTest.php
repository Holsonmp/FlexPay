<?php
use PHPUnit\Framework\TestCase;

class FlexPayTest extends TestCase 
{
    private $params;
    
    protected function setUp(): void
    {
        $this->params = [
            'merchant' => 'TEST_MERCHANT',
            'secretKey' => 'TEST_KEY',
            'testMode' => true,
            'invoiceid' => '12345',
            'amount' => '100.00',
            'currency' => 'USD',
            'clientdetails' => [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john@example.com',
                'phonenumber' => '1234567890'
            ],
            'systemurl' => 'https://whmcs.example.com',
            'returnurl' => 'https://whmcs.example.com/viewinvoice.php?id=12345',
            'paymentmethod' => 'flexpay'
        ];
    }

    public function testMetaData()
    {
        $meta = flexpay_MetaData();
        $this->assertEquals('FlexPay', $meta['DisplayName']);
        $this->assertEquals('1.1', $meta['APIVersion']);
    }

    public function testConfig() 
    {
        $config = flexpay_config();
        $this->assertArrayHasKey('merchant', $config);
        $this->assertArrayHasKey('secretKey', $config);
        $this->assertArrayHasKey('testMode', $config);
    }

    public function testLinkGeneration()
    {
        $html = flexpay_link($this->params);
        $this->assertStringContainsString('https://beta-cardpayment.flexpay.cd/v3/pay', $html);
        $this->assertStringContainsString('merchant=TEST_MERCHANT', $html);
        $this->assertStringContainsString('amount=100.00', $html);
    }
}