<?php foreach ($notifier->getNotifications() as $level => $notifications): ?>
    <?php foreach ($notifications as $notification): ?>
        <?php echo $notification ?>
    <?php endforeach; ?>
<?php endforeach; ?>