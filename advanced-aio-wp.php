<?php
/**
 * Plugin Name: Advanced All-in-One WP
 * Version: 2.0.5
 * Requires PHP: 8.1
 * Author: Optimized AIO Team
 * License: GPLv3
 * Text Domain: advanced-aio-wp
 */

defined('ABSPATH') || exit;

// Define core constants
define('AIO_WP_PATH', plugin_dir_path(__FILE__));
define('AIO_WP_URL', plugin_dir_url(__FILE__));
define('AIO_WP_VERSION', '2.0.5');

// Enhanced Autoloader with proper directory mapping
spl_autoload_register(function ($class_name) {
    $namespace = 'AIO_WP\\';
    
    if (strpos($class_name, $namespace) !== 0) return;

    $class_path = str_replace(
        [$namespace, '\\'],
        ['', '/'],
        $class_name
    );
    
    $file_name = 'class-' . strtolower(str_replace('_', '-', $class_path)) . '.php';

    $locations = [
        'core/',
        'security/',
        'admin/core-classes/',
        'public/core-classes/',
        'modules/text/',
        'modules/images/',
        'admin/'
    ];

    foreach ($locations as $dir) {
        $full_path = AIO_WP_PATH . $dir . $file_name;
        if (file_exists($full_path)) {
            require_once $full_path;
            return;
        }
    }
    
    error_log("[AIO Autoloader] Class not found: {$class_name} at {$full_path}");
});

// Initialize error handling first
require_once AIO_WP_PATH . 'admin/error-handlers/fallback-system.php';
AIO_WP\Admin\Fallback_System::handle_errors();

// Bootstrap the plugin
require_once AIO_WP_PATH . 'core/class-bootstrap.php';
register_activation_hook(__FILE__, ['AIO_WP\Bootstrap', 'activate']);
register_deactivation_hook(__FILE__, ['AIO_WP\Bootstrap', 'deactivate']);

add_action('plugins_loaded', function() {
    try {
        AIO_WP\Bootstrap::instance()->init();
    } catch (Throwable $e) {
        error_log('AIO Fatal Error: ' . $e->getMessage());
        if (defined('WP_DEBUG') && WP_DEBUG) {
            wp_die('Plugin initialization failed: ' . esc_html($e->getMessage()));
        }
    }
}, 5);
