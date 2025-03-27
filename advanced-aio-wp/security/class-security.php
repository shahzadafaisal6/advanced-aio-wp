<?php
namespace AdvancedAIO_WP\Security;

class Encryption {
    private $key;
    private $cipher = 'aes-256-gcm';
    private $iv_length;

    public function __construct() {
        if (!defined('AIO_ENCRYPTION_KEY')) {
            $this->generate_key();
        }
        $this->key = AIO_ENCRYPTION_KEY;
        $this->iv_length = openssl_cipher_iv_length($this->cipher);
    }

    public function encrypt($data) {
        $iv = random_bytes($this->iv_length);
        $tag = '';
        $encrypted = openssl_encrypt(
            $data,
            $this->cipher,
            $this->key,
            0,
            $iv,
            $tag
        );
        return base64_encode($iv.$tag.$encrypted);
    }

    private function generate_key() {
        if (!defined('AIO_ENCRYPTION_KEY')) {
            define('AIO_ENCRYPTION_KEY', bin2hex(random_bytes(32)));
        }
    }

    public function decrypt($data) {
        $data = base64_decode($data);
        $iv = substr($data, 0, $this->iv_length);
        $tag = substr($data, $this->iv_length, 16);
        $text = substr($data, $this->iv_length + 16);
        return openssl_decrypt(
            $text,
            $this->cipher,
            $this->key,
            0,
            $iv,
            $tag
        );
    }
}
