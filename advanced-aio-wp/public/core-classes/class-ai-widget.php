<?php
namespace AdvancedAIO_WP\PublicCore;

class AI_Widget extends \WP_Widget {
    public function __construct() {
        parent::__construct(
            'aio_ai_widget',
            'AI Assistant Widget',
            ['description' => 'Embeddable AI chat interface']
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        include ADVANCED_AIO_WP_DIR . 'public/partials/widget-ui.php';
        echo $args['after_widget'];
    }

    public function form($instance) {
        include ADVANCED_AIO_WP_DIR . 'public/partials/widget-settings.php';
    }
}
