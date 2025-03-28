<?php
namespace AdvancedAIO_WP\Admin\Core;

class Role_Manager {
    private $capabilities = [
        'aio_manage_modules' => 'Manage AI Modules',
        'aio_view_analytics' => 'View AI Analytics',
        'aio_manage_api_keys' => 'Manage API Keys'
    ];

    public function __construct() {
        add_action('init', [$this, 'add_custom_capabilities']);
    }

    public function add_custom_capabilities() {
        $admin = get_role('administrator');
        $editor = get_role('editor');

        foreach ($this->capabilities as $cap => $desc) {
            $admin->add_cap($cap);
            $editor->add_cap($cap);
        }
    }

    public function get_role_matrix() {
        return apply_filters('aio_wp_capabilities', $this->capabilities);
    }
}
