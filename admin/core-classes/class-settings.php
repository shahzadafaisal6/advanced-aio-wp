<?php
namespace AIO_WP\Admin;

defined('ABSPATH') || exit;

class Settings {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_menu() {
        add_menu_page(
            'AI Optimizer Settings',
            'AI Optimizer',
            'manage_options',
            'aio-wp-settings',
            [$this, 'settings_page'],
            'dashicons-shield'
        );
    }

    public function register_settings() {
        register_setting('aio_wp_settings_group', 'aio_wp_settings', [
            'sanitize_callback' => [$this, 'sanitize_settings']
        ]);

        add_settings_section('main_section', 'Core Settings', null, 'aio-wp-settings');

        add_settings_field('ai_api_key', 'AI API Key', [$this, 'api_key_field'], 
            'aio-wp-settings', 'main_section');
    }

    public function sanitize_settings($input) {
        $sanitized = [];
        $sanitized['ai_api_key'] = sanitize_text_field($input['ai_api_key'] ?? '');
        return $sanitized;
    }

    public function settings_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized access');
        }
        ?>
        <div class="wrap">
            <?php settings_errors(); ?>
            <form method="post" action="options.php">
                <?php 
                settings_fields('aio_wp_settings_group');
                do_settings_sections('aio-wp-settings');
                submit_button(); 
                ?>
            </form>
        </div>
        <?php
    }

    public function api_key_field() {
        $settings = get_option('aio_wp_settings');
        $value = esc_attr($settings['ai_api_key'] ?? '');
        echo '<input type="password" name="aio_wp_settings[ai_api_key]" value="'.$value.'" class="regular-text">';
    }
}
