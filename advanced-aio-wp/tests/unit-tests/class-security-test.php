<?php
use AdvancedAIO_WP\Security\Encryption;
use PHPUnit\Framework\TestCase;

class Security_Test extends TestCase {
    private $encryptor;

    protected function setUp(): void {
        define('AIO_ENCRYPTION_KEY', bin2hex(random_bytes(32)));
        $this->encryptor = new Encryption();
    }

    public function test_encryption() {
        $original = 'Sensitive Data';
        $encrypted = $this->encryptor->encrypt($original);
        $this->assertNotEquals($original, $encrypted);
        
        $decrypted = $this->encryptor->decrypt($encrypted);
        $this->assertEquals($original, $decrypted);
    }

    public function test_invalid_decryption() {
        $this->expectException(\Exception::class);
        $this->encryptor->decrypt('invalid_data');
    }
}
