<?php
use AdvancedAIO_WP\Modules\Text\OpenAI_Handler;
use PHPUnit\Framework\TestCase;

class OpenAI_Handler_Test extends TestCase {
    private $handler;

    protected function setUp(): void {
        $this->handler = new OpenAI_Handler('test_key');
    }

    public function test_generate_text() {
        $mock_response = [
            'body' => json_encode([
                'choices' => [
                    ['message' => ['content' => 'Test response']]
                ]
            ])
        ];

        add_filter('pre_http_request', function() use ($mock_response) {
            return $mock_response;
        });

        $result = $this->handler->generate_text('Test prompt');
        $this->assertEquals('Test response', $result);
    }

    public function test_api_error() {
        $this->expectException(\Exception::class);
        add_filter('pre_http_request', function() {
            return new WP_Error('api_error', 'Connection failed');
        });

        $this->handler->generate_text('Test prompt');
    }
}
