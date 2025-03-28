<div class="wrap aio-system-health">
    <h2>System Health Status</h2>
    
    <div class="aio-health-grid">
        <?php foreach ($health_checks as $check): ?>
        <div class="aio-health-card <?php echo $check['status']; ?>">
            <h3><?php echo $check['label']; ?></h3>
            <p><?php echo $check['message']; ?></p>
            <?php if (!empty($check['actions'])): ?>
            <div class="actions"><?php echo implode(' | ', $check['actions']); ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
