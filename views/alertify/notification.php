<script type="text/javascript">
    alertify<?php echo $notification->alertifyLevel; ?>(
        <?php if ( ! empty($notification->title)): ?>
            "<strong>" + "<?php echo $notification->title; ?>" + "</strong><br>"
        <?php endif; ?>
        <?php if ( ! empty($notification->message)): ?>
            <?php if ( ! empty($notification->title)): ?> + <?php endif; ?>"<?php echo $notification->message; ?>" + "<br>"
        <?php endif; ?>
	);
</script>