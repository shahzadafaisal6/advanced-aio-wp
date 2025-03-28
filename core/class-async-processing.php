<?php
namespace AdvancedAIO_WP\Core;

class Async_Processor {
    public static function dispatch($action, $data = []) {
        $args = [
            'timeout' => 0.01,
            'blocking' => false,
            'body' => array_merge($data, [
                'action' => $action,
                '_nonce' => wp_create_nonce('aio_async_' . $action)
            ])
        ];
        
        return wp_remote_post(admin_url('admin-ajax.php'), $args);
    }

    public static function register_handler($action, $callback) {
        add_action('wp_ajax_' . $action, $callback);
        add_action('wp_ajax_nopriv_' . $action, $callback);
    }
}
