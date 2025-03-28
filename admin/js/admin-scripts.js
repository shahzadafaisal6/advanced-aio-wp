jQuery(document).ready(function($) {
    // Module Toggle Handler
    $('.module-switch input').on('change', function() {
        const module = $(this).data('module');
        const isActive = $(this).is(':checked');
        
        $.post(ajaxurl, {
            action: 'aio_toggle_module',
            module: module,
            status: isActive ? 1 : 0,
            security: aio_admin.nonce
        }, function(response) {
            if (!response.success) {
                // Revert toggle on error
                $(this).prop('checked', !isActive);
                alert('Error: ' + response.data);
            }
        });
    });

    // API Test Buttons
    $('.api-test-btn').click(function() {
        const provider = $(this).data('provider');
        $(this).prop('disabled', true).text('Testing...');
        
        $.getJSON(aio_admin.ajax_url, {
            action: 'aio_test_api',
            provider: provider
        }, function(response) {
            const statusEl = $(`#${provider}-status`);
            statusEl.removeClass('error success').addClass(response.success ? 'success' : 'error')
                   .text(response.data.message);
        }).always(() => {
            $(this).prop('disabled', false).text('Test Connection');
        });
    });
});
