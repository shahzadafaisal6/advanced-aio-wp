<?php
namespace AdvancedAIO_WP\Admin\Core;

class Audit_Log {
    private $table = 'aio_audit_log';

    public function __construct() {
        add_action('aio_log_event', [$this, 'log'], 10, 3);
    }

    public function log($user_id, $action, $details = []) {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . $this->table,
            [
                'user_id' => absint($user_id),
                'action' => sanitize_text_field($action),
                'details' => maybe_serialize($details),
                'ip_address' => $this->get_client_ip(),
                'created_at' => current_time('mysql')
            ],
            ['%d', '%s', '%s', '%s', '%s']
        );
    }

    private function get_client_ip() {
        foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $key) {
            if (!empty($_SERVER[$key])) {
                return sanitize_text_field($_SERVER[$key]);
            }
        }
        return '0.0.0.0';
    }
}
