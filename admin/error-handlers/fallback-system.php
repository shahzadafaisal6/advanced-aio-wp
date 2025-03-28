<?php
namespace AIO_WP\Admin;

defined('ABSPATH') || exit;

class Fallback_System {
    public static function handle_errors() {
        set_exception_handler([__CLASS__, 'exception_handler']);
        set_error_handler([__CLASS__, 'error_handler']);
        register_shutdown_function([__CLASS__, 'shutdown_handler']);
    }

    public static function exception_handler(\Throwable $e) {
        error_log('AIO Exception: ' . $e->getMessage());
        if (defined('WP_DEBUG') && WP_DEBUG) {
            wp_die('<h1>Plugin Error</h1><p>' . esc_html($e->getMessage()) . '</p>');
        }
    }

    public static function error_handler($code, $message, $file, $line) {
        error_log("AIO Error [{$code}] {$message} in {$file} on line {$line}");
        return true;
    }

    public static function shutdown_handler() {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR])) {
            self::exception_handler(new \ErrorException(
                $error['message'], 0, $error['type'], $error['file'], $error['line']
            ));
        }
    }
}
