<?php
namespace AdvancedAIO_WP\Modules\Video;

class Synthesia_Handler {
    public function create_ai_video($script, $avatar_id = 'default', $background = null) {
        $response = wp_remote_post('https://api.synthesia.io/v2/videos', [
            'headers' => [
                'Authorization' => $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'test' => false,
                'input' => [['scriptText' => $script]],
                'avatar' => $avatar_id,
                'background' => $background,
                'callbackUrl' => rest_url('aio/video-callback')
            ])
        ]);

        return json_decode($response['body'], true);
    }
}
