<?php
namespace AdvancedAIO_WP\Modules\Voice;

class ElevenLabs_Handler {
    public function text_to_speech($text, $voice_id = '21m00Tcm4TlvDq8ikWAM', $stability = 0.5) {
        $response = wp_remote_post("https://api.elevenlabs.io/v1/text-to-speech/$voice_id", [
            'headers' => [
                'xi-api-key' => $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'text' => $text,
                'voice_settings' => ['stability' => $stability]
            ])
        ]);

        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['path'] . '/tts_' . uniqid() . '.mp3';
        file_put_contents($file_path, $response['body']);

        return $upload_dir['url'] . '/' . basename($file_path);
    }
}
