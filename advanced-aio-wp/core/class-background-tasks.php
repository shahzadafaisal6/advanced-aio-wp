<?php
namespace AdvancedAIO_WP\Core;

class Background_Task_Manager {
    private static $queue_name = 'aio_background_queue';

    public function __construct() {
        add_action('aio_process_queue', [$this, 'process_queue']);
        
        if (!wp_next_scheduled('aio_process_queue')) {
            wp_schedule_event(time(), 'five_minutes', 'aio_process_queue');
        }
    }

    public function add_task($callback, $args = [], $priority = 10) {
        $task_id = md5(serialize([$callback, $args]));
        
        wp_cache_add($task_id, [
            'callback' => $callback,
            'args' => $args,
            'attempts' => 0
        ], self::$queue_name, 86400);
        
        return $task_id;
    }

    public function process_queue() {
        global $wp_object_cache;
        
        $tasks = $wp_object_cache->get(self::$queue_name, 'aio_background');
        if (empty($tasks)) return;
        
        foreach ($tasks as $task_id => $task) {
            try {
                call_user_func_array($task['callback'], $task['args']);
                wp_cache_delete($task_id, self::$queue_name);
            } catch (\Exception $e) {
                $task['attempts']++;
                if ($task['attempts'] < 3) {
                    wp_cache_set($task_id, $task, self::$queue_name);
                } else {
                    error_log("Background task failed: " . print_r($task, true));
                }
            }
        }
    }
}
