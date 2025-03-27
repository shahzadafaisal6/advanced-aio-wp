<?php
namespace AdvancedAIO_WP\Security;

class Nonce_Manager {
    public function create($action = 'aio_default') {
        return wp_create_nonce('aio_'.$action);
    }

    public function verify($nonce, $action = 'aio_default') {
        return wp_verify_nonce($nonce, 'aio_'.$action);
    }

    public function validate_ajax_request($action) {
        check_ajax_referer('aio_'.$action, 'security');
    }
}
