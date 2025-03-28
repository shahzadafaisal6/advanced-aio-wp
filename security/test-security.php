<?php
namespace AIO_WP;

require_once('advanced-aio-wp.php');

class Security_Test {
    public static function run() {
        $security = new Security();
        $test_data = 'sensitive info';
        
        $encrypted = $security->encrypt_data($test_data);
        $decrypted = $security->decrypt_data($encrypted);
        
        echo $decrypted === $test_data ? 'Security OK' : 'Security FAIL';
    }
}

Security_Test::run();
