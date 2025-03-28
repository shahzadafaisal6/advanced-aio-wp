<?php
namespace AIO_WP;

defined('ABSPATH') || exit;

class Install {
    public static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $tables = [
            "CREATE TABLE {$wpdb->prefix}aio_cache (
                cache_key varchar(255) NOT NULL,
                cache_value longtext NOT NULL,
                expiration datetime NOT NULL,
                PRIMARY KEY  (cache_key)
            ) $charset_collate;"
        ];

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        foreach ($tables as $sql) {
            dbDelta($sql);
        }
    }
}
