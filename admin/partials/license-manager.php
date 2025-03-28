<div class="wrap aio-wrap">
    <h1>License Management</h1>
    
    <div class="aio-card">
        <form id="aio-license-form">
            <div class="license-field">
                <label for="license_key">Enter License Key:</label>
                <input type="password" id="license_key" name="license_key" 
                    value="<?php echo esc_attr($license_key); ?>" class="regular-text">
                <button type="button" id="validate-license" class="button button-primary">
                    <?php echo $is_valid ? 'Revalidate' : 'Activate'; ?>
                </button>
            </div>
            
            <div id="license-status" class="<?php echo $is_valid ? 'valid' : 'invalid'; ?>">
                <?php if ($is_valid) : ?>
                    <p>License valid until: <?php echo $expiry_date; ?></p>
                <?php else : ?>
                    <p>No active license found</p>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#validate-license').click(function() {
        const licenseKey = $('#license_key').val();
        // AJAX validation logic
    });
});
</script>
