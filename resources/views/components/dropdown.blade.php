@props(['title', 'links' => []])
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon">
            <em class="icon ni ni-files"></em>
        </span>
        <span class="nk-menu-text">{{ $title }}</span>
    </a>
    <ul class="nk-menu-sub">
        @foreach ($links as $key => $value)
            <li class="nk-menu-item">
                <a href="{{ $value }}" class="nk-menu-link">
                    <span class="nk-menu-text">{{ $key }}</span>
                </a>
            </li>
        @endforeach
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

