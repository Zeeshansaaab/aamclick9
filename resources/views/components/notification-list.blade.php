<div class="dropdown-body">
    <div class="nk-notification">
        @foreach ($notifications as $notification)
            <x-notification-item :notification="$notification" />
        @endforeach
    </div><!-- .nk-notification -->
    @if(count($notifications) == 0)
        <p class="text-center p-4">No notifications to show</p>
    @endif
</div><!-- .nk-dropdown-body -->