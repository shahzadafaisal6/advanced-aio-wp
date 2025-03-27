<?php
namespace AdvancedAIO_WP\PublicCore;

class Frontend_API {
    public function __construct() {
        add_action('wp_ajax_aio_process_request', [$this, 'handle_request']);
        add_action('wp_ajax_nopriv_aio_process_request', [$this, 'handle_request']);
    }

    public function handle_request() {
        check_ajax_referer('aio_public_nonce', 'security');

        $module = sanitize_text_field($_POST['module']);
        $action = sanitize_text_field($_POST['action']);

        try {
            $result = apply_filters("aio_frontend_{$module}_{$action}", [], $_POST);
            wp_send_json_success($result);
        } catch (\Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }
}
