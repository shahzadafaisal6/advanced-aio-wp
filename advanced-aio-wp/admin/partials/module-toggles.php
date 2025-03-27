<div class="wrap aio-wrap">
    <h1>Module Control Center</h1>
    
    <div class="aio-card">
        <?php foreach ($modules as $module => $config) : ?>
        <div class="module-toggle">
            <div class="module-info">
                <h3><?php echo esc_html($config['name']); ?></h3>
                <p><?php echo esc_html($config['description']); ?></p>
            </div>
            
            <label class="module-switch">
                <input type="checkbox" data-module="<?php echo esc_attr($module); ?>" 
                    <?php checked($config['active']); ?>>
                <span class="slider round"></span>
            </label>
        </div>
        <?php endforeach; ?>
    </div>
</div>
