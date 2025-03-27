<?php
namespace AdvancedAIO_WP\Admin\ErrorHandlers;

class Fallback_System {
    private static $fallback_map = [
        'openai_text' => 'local_llm',
        'dalle_image' => 'stable_diffusion'
    ];

    public static function activate_fallback($failed_service) {
        if (!array_key_exists($failed_service, self::$fallback_map)) {
            return false;
        }

        $fallback_service = self::$fallback_map[$failed_service];
        update_option("aio_active_module_$failed_service", 'disabled');
        update_option("aio_active_module_$fallback_service", 'enabled');
        
        return $fallback_service;
    }

    public static function get_fallback_message($original_service) {
        $messages = [
            'openai_text' => 'Switched to local LLM (quality may vary)',
            'dalle_image' => 'Falling back to Stable Diffusion'
        ];
        
        return $messages[$original_service] ?? 'Fallback activated';
    }
}
