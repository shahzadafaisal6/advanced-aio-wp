<?php
namespace AdvancedAIO_WP\Security;

class Activity_Logger {
    private $table = 'aio_activity_log';

    public function log($user_id, $action, $details = []) {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . $this->table,
            [
                'user_id' => $user_id,
                'action' => $action,
                'ip_address' => $this->get_client_ip(),
                'details' => maybe_serialize($details),
                'timestamp' => current_time('mysql')
            ],
            ['%d', '%s', '%s', '%s', '%s']
        );
    }

    private function get_client_ip() {
        // Implementation from Firewall class
    }
}
