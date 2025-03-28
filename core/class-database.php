<?php
namespace AIO_WP;

defined('ABSPATH') || exit;

class Database {
    private $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function safe_query($sql, $params = []) {
        $prepared = $this->wpdb->prepare($sql, $params);
        return $this->wpdb->get_results($prepared);
    }

    public function insert_data($table, $data) {
        $table = $this->wpdb->prefix . $table;
        return $this->wpdb->insert($table, $data);
    }
}
