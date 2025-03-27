<?php
namespace AdvancedAIO_WP\Security;

class Firewall {
    const BLOCK_THRESHOLD = 5;
    const BLOCK_TIME = 3600;
    
    public function __construct() {
        add_action('init', [$this, 'monitor_requests']);
        add_filter('authenticate', [$this, 'check_login_attempts'], 30, 3);
    }

    public function monitor_requests() {
        $ip = $this->get_client_ip();
        $transient = "aio_blocked_" . md5($ip);

        if (get_transient($transient)) {
            $this->block_access();
        }

        $this->log_request($ip);
    }

    private function block_access() {
        wp_die('<h1>Access Restricted</h1><p>Too many requests from your IP address. Please try again later.</p>', 
            'Access Restricted', 
            ['response' => 429]
        );
    }
    
    // Rest of firewall logic remains same...
}
