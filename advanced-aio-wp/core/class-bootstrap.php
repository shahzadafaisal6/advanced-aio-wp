<?php
namespace AdvancedAIO_WP\Core;

class Bootstrap {
    private $components = [];

    public function __construct() {
        $this->init_autoloader();
        $this->init_components();
        add_action('init', [$this, 'init']);
    }

    private function init_autoloader() {
        require_once __DIR__ . '/class-autoloader.php';
        $autoloader = new Autoloader();
        $autoloader->register();
    }

    private function init_components() {
        // Load core components first
        $this->components['database'] = new Database_Manager();
        $this->components['performance'] = new Performance_Optimizer();
        
        // Then admin/public components
        if (is_admin()) {
            $this->components['admin_settings'] = new \AdvancedAIO_WP\Admin\Core\Settings_Manager();
            $this->components['audit_log'] = new \AdvancedAIO_WP\Admin\Core\Audit_Log();
        } else {
            $this->components['frontend_api'] = new \AdvancedAIO_WP\PublicCore\Frontend_API();
        }
    }

    public function init() {
        load_plugin_textdomain(
            'advanced-aio-wp',
            false,
            dirname(plugin_basename(ADVANCED_AIO_WP_FILE)) . '/languages/'
        );
    }
}

class Activator {
    public static function activate() {
        require_once __DIR__ . '/class-database.php';
        (new Database_Manager())->create_tables();
        flush_rewrite_rules();
    }
}

class Deactivator {
    public static function deactivate() {
        wp_clear_scheduled_hook('aio_daily_maintenance');
    }
}
