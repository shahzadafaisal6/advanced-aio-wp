<?php
class AIO_WP_AI_Processor {
    private $security;
    
    public function __construct() {
        $this->security = new AIO_WP_Security();
    }

    public function generate_content($prompt) {
        $clean_prompt = $this->security->sanitize($prompt);
        
        $cache_key = 'aio_ai_' . md5($clean_prompt);
        if ($cached = get_transient($cache_key)) {
            return $cached;
        }

        $api_key = $this->get_api_key();
        $response = wp_remote_post('https://api.openai.com/v1/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => "text-davinci-003",
                'prompt' => $clean_prompt,
                'temperature' => 0.7,
                'max_tokens' => 256
            ]),
            'timeout' => 15,
            'sslverify' => true
        ]);

        if (is_wp_error($response)) {
            error_log('AI API Error: ' . $response->get_error_message());
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        $content = $this->sanitize_ai_response($body['choices'][0]['text']);
        
        set_transient($cache_key, $content, HOUR_IN_SECONDS);
        
        return $content;
    }

    private function sanitize_ai_response($text) {
        $allowed_tags = wp_kses_allowed_html('post');
        return wp_kses($text, $allowed_tags);
    }

    private function get_api_key() {
        $settings = get_option('aio_wp_settings');
        return $settings['ai_api_key'] ?? '';
    }
}
