<?php
namespace AIO_WP;

defined('ABSPATH') || exit;

final class Bootstrap {
    private static $instance;
    private $security;
    private $database;

    public static function instance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->verify_dependencies();
        $this->security = new Security();
        $this->database = new Database();
    }

    private function verify_dependencies() {
        $required_classes = [
            'AIO_WP\\Security',
            'AIO_WP\\Database',
            'AIO_WP\\Admin\\Settings'
        ];

        foreach ($required_classes as $class) {
            if (!class_exists($class)) {
                throw new \RuntimeException("Missing required class: {$class}");
            }
        }

        if (version_compare(PHP_VERSION, '8.1', '<')) {
            throw new \RuntimeException('Requires PHP 8.1+');
        }
    }

    public function init() {
        $this->init_admin();
        $this->init_public();
        $this->register_hooks();
    }

    private function init_admin() {
        if (is_admin()) {
            new Admin\Settings();
            new Admin\Audit_Log();
        }
    }

    private function init_public() {
        if (!is_admin()) {
            new Public\Shortcodes();
        }
    }

    private function register_hooks() {
        add_action('wp_ajax_aio_process', [$this, 'ajax_handler']);
    }

    public static function activate() {
        require_once AIO_WP_PATH . 'core/class-install.php';
        Install::create_tables();
    }

    public static function deactivate() {
        // Cleanup temporary data
    }
}
