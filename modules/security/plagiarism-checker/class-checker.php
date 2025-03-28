<?php
namespace AdvancedAIO_WP\Modules\Security;

class Plagiarism_Checker {
    public function check_content($content, $strictness = 'medium') {
        $response = wp_remote_post('https://api.copyleaks.com/v3/scans/submit/text', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'text' => $content,
                'scanMethod' => [
                    'internet' => true,
                    'database' => true
                ],
                'sensitivityLevel' => $strictness
            ])
        ]);

        return json_decode($response['body'], true);
    }
}
