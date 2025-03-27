<?php
namespace AdvancedAIO_WP\Core;

class Autoloader {
    private $prefix = 'AdvancedAIO_WP\\';
    private $base_dir;
    private $class_map = [];

    public function __construct() {
        $this->base_dir = dirname(__DIR__);
        $this->build_class_map();
    }

    public function register() {
        spl_autoload_register([$this, 'load_class']);
    }

    private function build_class_map() {
        $this->class_map = [
            'AdvancedAIO_WP\\Core\\Database_Manager' => 'class-database.php',
            'AdvancedAIO_WP\\Core\\Performance_Optimizer' => 'class-performance-optimizer.php',
            'AdvancedAIO_WP\\Admin\\Core\\Settings_Manager' => '../admin/core-classes/class-admin-settings.php',
            'AdvancedAIO_WP\\Admin\\Core\\Audit_Log' => '../admin/core-classes/class-audit-log.php',
            'AdvancedAIO_WP\\PublicCore\\Frontend_API' => '../public/core-classes/class-frontend-api.php'
        ];
    }

    public function load_class($class) {
        if (isset($this->class_map[$class])) {
            require $this->base_dir . '/core/' . $this->class_map[$class];
            return;
        }

        if (strpos($class, $this->prefix) === 0) {
            $relative_class = substr($class, strlen($this->prefix));
            $file = $this->base_dir . '/' . str_replace('\\', '/', $relative_class) . '.php';
            
            if (file_exists($file)) {
                require $file;
            }
        }
    }
}
