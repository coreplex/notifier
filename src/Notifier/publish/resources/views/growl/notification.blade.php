<script type="text/javascript">
    $.growl{{ $notification->growlLevel }}({ title: "{{ $notification->title }}", message: "{{ $notification->message }}" });
</script>