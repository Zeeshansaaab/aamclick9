@props(['link', 'icon', 'title', 'active'])

<li {{ $attributes }} class="k-menu-item">
    <a href="{{ $link }}" class="nk-menu-link">
        <span class="nk-menu-icon">
            <em class="{{ $icon }}"></em>
        </span>
        <span class="nk-menu-text">{{ $title }}</span>
    </a>
</li>
