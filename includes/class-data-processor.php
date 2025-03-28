<?php
class AIO_WP_Data_Processor {
    private $wpdb;
    private $security;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->security = new AIO_WP_Security();
    }

    public function get_optimized_data($params) {
        $clean_params = $this->security->sanitize($params);
        
        $cache_key = 'aio_data_' . md5(json_encode($clean_params));
        $cached = get_transient($cache_key);
        
        if ($cached !== false) {
            return $cached;
        }

        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->wpdb->prefix}aio_wp_data 
            WHERE created_at > %s 
            ORDER BY id DESC 
            LIMIT 100",
            date('Y-m-d H:i:s', strtotime('-7 days'))
        );

        $results = $this->wpdb->get_results($query, ARRAY_A);
        
        if ($this->wpdb->last_error) {
            error_log('AIO Database Error: ' . $this->wpdb->last_error);
            return [];
        }

        set_transient($cache_key, $results, 15 * MINUTE_IN_SECONDS);
        
        return $results;
    }

    public function safe_insert($data) {
        $clean_data = $this->security->sanitize($data);
        
        $result = $this->wpdb->insert(
            "{$this->wpdb->prefix}aio_wp_data",
            ['data' => maybe_serialize($clean_data)],
            ['%s']
        );
        
        return $result !== false;
    }
}
