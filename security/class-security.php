<?php
namespace AIO_WP;

defined('ABSPATH') || exit;

class Security {
    private $encryption_key;

    public function __construct() {
        $this->encryption_key = $this->get_encryption_key();
    }

    private function get_encryption_key() {
        if (defined('AIO_ENCRYPTION_KEY')) {
            return AIO_ENCRYPTION_KEY;
        }
        
        $key = get_option('aio_encryption_key');
        if (!$key || strlen($key) !== 64) {
            $key = bin2hex(random_bytes(32));
            update_option('aio_encryption_key', $key);
        }
        return $key;
    }

    public function sanitize_input($input, $type = 'text') {
        // ... existing sanitization methods ...
    }
}
