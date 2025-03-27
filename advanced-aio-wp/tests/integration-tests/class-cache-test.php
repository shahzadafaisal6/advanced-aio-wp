<?php
use AdvancedAIO_WP\Core\Redis_Cache;
use PHPUnit\Framework\TestCase;

class Cache_Integration_Test extends TestCase {
    private $cache;

    protected function setUp(): void {
        $this->cache = new Redis_Cache();
    }

    public function test_set_get() {
        $this->assertTrue($this->cache->set('test_key', 'test_value', 60));
        $this->assertEquals('test_value', $this->cache->get('test_key'));
    }

    public function test_expiration() {
        $this->cache->set('temp_key', 'temp_val', 1);
        sleep(2);
        $this->assertNull($this->cache->get('temp_key'));
    }

    protected function tearDown(): void {
        $this->cache->purge_all();
    }
}
