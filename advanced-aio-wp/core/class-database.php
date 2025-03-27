<?php
namespace AdvancedAIO_WP\Core;

class Database_Manager {
    private $tables = [
        'aio_cache' => "(
            cache_key varchar(255) NOT NULL,
            cache_value longtext NOT NULL,
            expires datetime NOT NULL,
            PRIMARY KEY (cache_key),
            INDEX expires_idx (expires)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        'aio_audit_log' => "(
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            action varchar(100) NOT NULL,
            details text NOT NULL,
            ip_address varchar(45) NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY (id),
            INDEX user_action_idx (user_id, action)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];

    public function create_tables() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        
        foreach ($this->tables as $table => $schema) {
            dbDelta("CREATE TABLE {$wpdb->prefix}{$table} {$schema};");
        }
        
        $this->migrate_legacy_data(); // If needed
    }

    private function migrate_legacy_data() {
        // Optional migration logic
    }
}
