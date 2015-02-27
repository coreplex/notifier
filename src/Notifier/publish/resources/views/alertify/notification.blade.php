<script type="text/javascript">
    alertify{{ $notification->alertifyLevel }}(
        @if ( ! empty($notification->title))
            "<strong>" + "{{ $notification->title }}" + "</strong><br>"
        @endif
        @if ( ! empty($notification->message))
            @if ( ! empty($notification->title)) + @endif"{{ $notification->message }}" + "<br>"
        @endif
);
</script>