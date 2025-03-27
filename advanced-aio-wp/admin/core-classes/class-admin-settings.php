<?php
namespace AdvancedAIO_WP\Admin\Core;

class Settings_Manager {
    private $menu_slug = 'aio-wp-dashboard';
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_pages']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function add_admin_pages() {
        add_menu_page(
            'AI Power Tools', 
            'AI Suite', 
            'manage_options', 
            $this->menu_slug, 
            [$this, 'render_dashboard'], 
            'dashicons-robot', 
            80
        );

        $this->add_subpages();
    }

    private function add_subpages() {
        $subpages = [
            [
                'title' => 'Module Control',
                'menu' => 'Modules',
                'slug' => 'aio-wp-modules',
                'callback' => [$this, 'render_modules']
            ],
            [
                'title' => 'License Manager',
                'menu' => 'License',
                'slug' => 'aio-wp-license',
                'callback' => [$this, 'render_license']
            ],
            [
                'title' => 'System Health',
                'menu' => 'Health',
                'slug' => 'aio-wp-health',
                'callback' => [$this, 'render_health']
            ]
        ];

        foreach ($subpages as $subpage) {
            add_submenu_page(
                $this->menu_slug,
                $subpage['title'],
                $subpage['menu'],
                'manage_options',
                $subpage['slug'],
                $subpage['callback']
            );
        }
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, $this->menu_slug) === false) return;
        
        wp_enqueue_style('aio-admin-css', 
            plugins_url('admin/css/admin-styles.css', ADVANCED_AIO_WP_FILE));
        
        wp_enqueue_script('aio-admin-js', 
            plugins_url('admin/js/admin-scripts.js', ADVANCED_AIO_WP_FILE), 
            ['jquery'], 
            filemtime(ADVANCED_AIO_WP_DIR . 'admin/js/admin-scripts.js'), 
            true
        );
        
        wp_localize_script('aio-admin-js', 'aio_admin', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aio_admin_nonce')
        ]);
    }

    // Rest of the class remains same...
}
