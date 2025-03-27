<?php
namespace AdvancedAIO_WP\Modules\Images;

class DALL_E_Handler {
    private $api_key;

    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    public function generate_image($prompt, $size = '1024x1024') {
        $response = wp_remote_post('https://api.openai.com/v1/images/generations', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'prompt' => sanitize_text_field($prompt),
                'n' => 1,
                'size' => $size,
                'response_format' => 'b64_json' // Critical change
            ]),
            'timeout' => 30
        ]);

        if (is_wp_error($response)) {
            throw new \Exception('API Error: ' . $response->get_error_message());
        }

        $body = json_decode($response['body'], true);
        return $this->save_base64_image($body['data'][0]['b64_json']);
    }

    private function save_base64_image($base64) {
        $upload_dir = wp_upload_dir();
        $filename = 'dalle_' . uniqid() . '.png';
        $filepath = $upload_dir['path'] . '/' . $filename;

        if (!file_put_contents($filepath, base64_decode($base64))) {
            throw new \Exception('Failed to save image');
        }

        return [
            'url' => $upload_dir['url'] . '/' . $filename,
            'path' => $filepath
        ];
    }
}
