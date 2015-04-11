<script type="text/javascript">
    $.growl<?php echo $notification->growlLevel; ?>({ title: "<?php echo  $notification->title; ?>", message: "<?php echo $notification->message; ?>" });
</script>