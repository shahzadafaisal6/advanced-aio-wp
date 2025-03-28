<?php
use AdvancedAIO_WP\Core\Bootstrap;
use PHPUnit\Framework\TestCase;

class Plugin_Init_Test extends TestCase {
    public function test_constants_defined() {
        $this->assertTrue(defined('ADVANCED_AIO_WP_VERSION'));
        $this->assertTrue(defined('ADVANCED_AIO_WP_DIR'));
    }

    public function test_hooks_registered() {
        $this->assertNotFalse(has_action('init', [Bootstrap::class, 'init']));
        $this->assertNotFalse(has_action('admin_menu', [Bootstrap::class, 'admin_menu']));
    }

    public function test_security_headers() {
        ob_start();
        do_action('send_headers');
        $headers_list = headers_list();
        ob_end_clean();
        
        $this->assertContains('X-Content-Type-Options: nosniff', $headers_list);
    }
}
