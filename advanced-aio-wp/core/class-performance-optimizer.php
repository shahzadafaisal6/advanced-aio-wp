<?php
namespace AdvancedAIO_WP\Core;

class Performance_Optimizer {
    private static $instance;
    
    public static function init() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action('template_redirect', [$this, 'buffer_start']);
        add_action('shutdown', [$this, 'buffer_end']);
    }

    public function buffer_start() {
        ob_start([$this, 'optimize_output']);
    }

    public function buffer_end() {
        if (ob_get_level() > 0) {
            ob_end_flush();
        }
    }

    public function optimize_output($html) {
        // HTML minification
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);
        $html = preg_replace('/\s{2,}/', ' ', $html);
        
        // Defer non-critical CSS/JS
        $html = preg_replace_callback('/<link(.*?)>/', [$this, 'defer_styles'], $html);
        $html = preg_replace_callback('/<script(.*?)>(.*?)<\/script>/is', [$this, 'defer_scripts'], $html);
        
        return $html;
    }

    private function defer_styles($matches) {
        if (strpos($matches[1], 'stylesheet') && !strpos($matches[1], 'critical')) {
            return '<link rel="preload" as="style" ' . $matches[1] . ' onload="this.onload=null;this.rel=\'stylesheet\'">';
        }
        return $matches[0];
    }
}
