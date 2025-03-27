<?php
/**
 * Plugin Name: Advanced AIO WP
 * Description: AI-Powered Everything – Smarter, Faster, Better!
 * Version: 1.0.0
 * Author: Hamna_Tech Solutions LLC
 * Author URI: https://hamnatech.com
 * License: GPLv3
 * Text Domain: advanced-aio-wp
 * Requires at least: 6.4
 * Requires PHP: 7.4
 */

defined('ABSPATH') || exit;

// Define core constants
define('ADVANCED_AIO_WP_VERSION', '1.0.0');
define('ADVANCED_AIO_WP_FILE', __FILE__);
define('ADVANCED_AIO_WP_DIR', plugin_dir_path(__FILE__));
define('ADVANCED_AIO_WP_URL', plugin_dir_url(__FILE__));

// Check for required PHP version
if (version_compare(PHP_VERSION, '7.4', '<')) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p>';
        printf(
            __('Advanced AIO WP requires PHP 7.4 or higher. Your server is running PHP %s.', 'advanced-aio-wp'),
            PHP_VERSION
        );
        echo '</p></div>';
    });
    return;
}

// Disable WordPress.org update checks if connection fails
add_filter('http_request_args', function($args, $url) {
    if (strpos($url, 'api.wordpress.org/plugins/update-check') !== false) {
        $args['timeout'] = 5;
        $args['sslverify'] = false;
    }
    return $args;
}, 10, 2);

// Initialize plugin
require_once ADVANCED_AIO_WP_DIR . 'core/class-autoloader.php';
require_once ADVANCED_AIO_WP_DIR . 'core/class-bootstrap.php';

register_activation_hook(__FILE__, ['AdvancedAIO_WP\Core\Activator', 'activate']);
register_deactivation_hook(__FILE__, ['AdvancedAIO_WP\Core\Deactivator', 'deactivate']);

new AdvancedAIO_WP\Core\Bootstrap();
