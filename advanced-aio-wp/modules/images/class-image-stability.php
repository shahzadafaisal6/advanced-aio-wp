<?php
namespace AdvancedAIO_WP\Modules\Images;

class StabilityAI_Handler {
    public function text_to_image($prompt, $engine_id = 'stable-diffusion-xl-1024-v1-0') {
        $response = wp_remote_post("https://api.stability.ai/v1/generation/$engine_id/text-to-image", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Accept' => 'application/json'
            ],
            'body' => json_encode([
                'text_prompts' => [['text' => $prompt]],
                'cfg_scale' => 7,
                'steps' => 30
            ])
        ]);

        $body = json_decode($response['body'], true);
        return $this->save_base64_image($body['artifacts'][0]['base64']);
    }
}
