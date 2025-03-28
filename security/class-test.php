<?php
namespace AIO_WP;

require_once __DIR__.'/../advanced-aio-wp.php';

class Security_Test {
    public static function run() {
        try {
            $security = new Security();
            $test_data = 'test@example.com';
            echo "Sanitized email: " . $security->sanitize_input($test_data, 'email');
            echo "\nSecurity class loaded successfully!";
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

Security_Test::run();
