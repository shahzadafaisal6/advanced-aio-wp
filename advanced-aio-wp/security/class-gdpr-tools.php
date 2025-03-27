<?php
namespace AdvancedAIO_WP\Security;

class GDPR_Tools {
    public static function erase_user_data($user_id) {
        global $wpdb;

        // Anonymize audit logs
        $wpdb->update(
            $wpdb->prefix . 'aio_audit_log',
            ['user_id' => 0, 'ip_address' => '0.0.0.0'],
            ['user_id' => $user_id]
        );

        // Purge cached data
        $transients = $wpdb->get_col(
            "SELECT option_name FROM $wpdb->options 
             WHERE option_name LIKE '_transient_aio_user_{$user_id}_%'"
        );

        foreach ($transients as $transient) {
            delete_transient(str_replace('_transient_', '', $transient));
        }

        return count($transients);
    }

    public static function export_user_data($user_id) {
        // Implementation for data portability
    }
}
