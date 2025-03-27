<?php
namespace AdvancedAIO_WP\Core;

class Updater {
    private $update_server = 'https://updates.hamnatech.com/v1/';
    private $fallback_server = 'http://backup.hamnatech.com/v1/';

    public function __construct() {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_update']);
        add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
    }

    public function check_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $response = $this->get_update_data();
        
        if ($response && version_compare(ADVANCED_AIO_WP_VERSION, $response->version, '<')) {
            $transient->response['advanced-aio-wp/advanced-aio-wp.php'] = $response;
        }

        return $transient;
    }

    private function get_update_data() {
        $args = [
            'timeout' => 10,
            'sslverify' => false
        ];

        try {
            $response = wp_remote_get($this->update_server . 'check', $args);
            
            if (is_wp_error($response)) {
                $response = wp_remote_get($this->fallback_server . 'check', $args);
            }

            return json_decode(wp_remote_retrieve_body($response));
        } catch (\Exception $e) {
            error_log('Update check failed: ' . $e->getMessage());
            return false;
        }
    }

    public function plugin_info($res, $action, $args) {
        if ($action !== 'plugin_information' || $args->slug !== 'advanced-aio-wp') {
            return $res;
        }

        $info = $this->get_update_data();
        return $info ?: $res;
    }
}
