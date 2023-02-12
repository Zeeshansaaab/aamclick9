@props(['title', 'links' => [], 'icon'])
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle" >
        <span class="nk-menu-icon">
            <em class="icon ni {{$icon}}"></em>
        </span>
        <span class="nk-menu-text">{{ $title }}</span>
    </a>
    <ul class="nk-menu-sub" style="display: none;">
        @foreach ($links as $key => $value)
        @php
            $routeAndParams = explode(', ', $value);
            $route  = $routeAndParams[0];
            $params = count($routeAndParams) > 1 ? $routeAndParams[1] : null;
            if(count($routeAndParams) == 1){
                $route = $value;
            }
        @endphp
            <li class="nk-menu-item">
                <a href="{{ $route ? ($params ? route($route, explode(',', $params)) : route($route)) : '' }}" class="nk-menu-link">
                    <span class="nk-menu-text">{{ $key }}</span>
                </a>
            </li>
        @endforeach
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->
