<?php
namespace AdvancedAIO_WP\Modules\Text;

class OpenAI_Handler {
    private $api_key;
    private $endpoint = 'https://api.openai.com/v1/chat/completions';
    private $timeout = 30;

    public function __construct($api_key) {
        if (empty($api_key)) {
            throw new \InvalidArgumentException('OpenAI API key is required');
        }
        $this->api_key = sanitize_text_field($api_key);
    }

    public function generate_text($prompt, $model = 'gpt-4', $max_tokens = 1000) {
        $args = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => $max_tokens,
                'temperature' => 0.7
            ]),
            'timeout' => $this->timeout
        ];

        $response = wp_safe_remote_post($this->endpoint, $args);

        if (is_wp_error($response)) {
            throw new \Exception('API Error: ' . $response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid API response format');
        }

        return $body['choices'][0]['message']['content'] ?? '';
    }
}
