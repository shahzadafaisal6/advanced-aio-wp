<div class="wrap aio-wrap">
    <h1 class="wp-heading-inline">
        <span class="aio-logo"></span>
        AI Power Dashboard
    </h1>
    
    <nav class="aio-nav-tabs">
        <?php foreach ($this->get_tabs() as $tab): ?>
            <a href="<?php echo esc_url($tab['url']); ?>" 
               class="nav-tab <?php echo $tab['active'] ? 'nav-tab-active' : ''; ?>">
                <?php echo esc_html($tab['label']); ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="aio-card">
        <h2>Quick Actions</h2>
        <div class="aio-grid">
            <div class="aio-grid-item">
                <h3>API Status</h3>
                <div id="api-status-badge" class="aio-status loading"></div>
            </div>
            <div class="aio-grid-item">
                <h3>Active Modules</h3>
                <div class="aio-module-count"><?php echo count($active_modules); ?></div>
            </div>
        </div>
    </div>

    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php 
        settings_fields('aio_wp_settings_group');
        do_settings_sections('aio-wp-dashboard');
        submit_button('Save Settings'); 
        ?>
    </form>
</div>
