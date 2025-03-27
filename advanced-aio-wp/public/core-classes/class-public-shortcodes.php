<?php
namespace AdvancedAIO_WP\PublicCore;

class Shortcode_Manager {
    public function __construct() {
        add_shortcode('aio_text_generator', [$this, 'render_text_generator']);
        add_shortcode('aio_image_generator', [$this, 'render_image_generator']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    public function render_text_generator($atts) {
        ob_start();
        include ADVANCED_AIO_WP_DIR . 'public/partials/text-generator.php';
        return ob_get_clean();
    }

    public function register_assets() {
        wp_register_style('aio-public', ADVANCED_AIO_WP_URL . 'public/css/public-styles.css');
        wp_register_script('aio-widget', ADVANCED_AIO_WP_URL . 'public/js/ai-widget.js', ['jquery'], null, true);
        wp_localize_script('aio-widget', 'aio_public', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aio_public_nonce')
        ]);
    }
}
