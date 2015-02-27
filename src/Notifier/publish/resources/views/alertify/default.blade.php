@foreach ($notifier->getNotifications() as $level => $notifications)
    @foreach($notifications as $notification)
        {!! $notification !!}
    @endforeach
@endforeach