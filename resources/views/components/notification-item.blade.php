@props([
    'notification'
])
<div class="nk-notification-item dropdown-inner">
    <div class="nk-notification-icon">
        <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
    </div>
    <div class="nk-notification-content">
        <a href="{{ $notification->data['redirect_url'] }}">
            <div class="nk-notification-text fw-bold">{{ $notification->data['title'] }}</div>
            <div class="nk-notification-text text-sm">{{ $notification->data['description'] }}</div>
            <div class="nk-notification-time">{{ $notification->created_at->diffForHumans() }}</div>
        </a>
    </div>
</div>