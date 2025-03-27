<?php
namespace AdvancedAIO_WP\Core;

class Redis_Cache {
    private $redis;
    private $prefix = 'aio_cache_';
    private $enabled = false;

    public function __construct() {
        if (extension_loaded('redis')) {
            $this->redis = new \Redis();
            try {
                $this->enabled = $this->redis->connect(
                    defined('AIO_REDIS_HOST') ? AIO_REDIS_HOST : '127.0.0.1',
                    defined('AIO_REDIS_PORT') ? AIO_REDIS_PORT : 6379,
                    2 // timeout
                );
            } catch (\Exception $e) {
                error_log('Redis connection failed: ' . $e->getMessage());
            }
        }
    }

    public function get($key, $default = null) {
        if (!$this->enabled) return $default;
        
        $value = $this->redis->get($this->prefix . $key);
        return $value !== false ? unserialize($value) : $default;
    }

    public function set($key, $value, $ttl = 3600) {
        if (!$this->enabled) return false;
        
        return $this->redis->setex(
            $this->prefix . $key,
            $ttl,
            serialize($value)
        );
    }

    public function purge_all() {
        $keys = $this->redis->keys($this->prefix . '*');
        return $this->redis->del($keys);
    }
}
