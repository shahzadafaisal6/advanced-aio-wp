<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

// Remove options
delete_option('advanced_aio_wp_settings');
delete_option('advanced_aio_wp_license_key');

// Drop custom tables
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}aio_audit_log");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}aio_api_cache");

// Clear scheduled events
wp_clear_scheduled_hook('advanced_aio_daily_maintenance');
