<?php
namespace AdvancedAIO_WP\Admin\ErrorHandlers;

class API_Error_Logger {
    private static $log_table = 'aio_api_errors';

    public static function log($api, $error, $context = []) {
        global $wpdb;
        
        $wpdb->insert(
            $wpdb->prefix . self::$log_table,
            [
                'api_provider' => substr($api, 0, 50),
                'error_code' => $error->getCode(),
                'error_message' => $error->getMessage(),
                'request_data' => maybe_serialize($context),
                'timestamp' => current_time('mysql')
            ],
            ['%s', '%d', '%s', '%s', '%s']
        );
        
        // Trigger admin notification for critical errors
        if ($error->getCode() >= 500) {
            self::notify_admin($api, $error);
        }
    }

    private static function notify_admin($api, $error) {
        $subject = sprintf('[Critical] API Failure: %s', $api);
        $message = sprintf(
            "API Error Detected:\n\nProvider: %s\nCode: %d\nMessage: %s",
            $api,
            $error->getCode(),
            $error->getMessage()
        );
        
        wp_mail(get_option('admin_email'), $subject, $message);
    }
}
