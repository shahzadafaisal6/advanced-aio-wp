<?php
namespace AdvancedAIO_WP\Modules\Text;

class Gemini_Handler {
    private $api_key;
    private $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

    public function generate_text($prompt, $params = []) {
        $url = add_query_arg(['key' => $this->api_key], $this->endpoint);
        
        $response = wp_remote_post($url, [
            'body' => json_encode([
                'contents' => [['parts' => [['text' => $prompt]]]]
            ])
        ]);

        $body = json_decode($response['body'], true);
        return $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }
}
