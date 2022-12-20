@props(['links' => [], 'currentPage', 'title', 'subTitle' => ''])
    <div class="nk-block-head-sub">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach($links as $key => $value)
                    <li class="breadcrumb-item">
                        <a href="{{ route($value) }}">{{ $key }}</a>
                    </li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{ $currentPage }}</li>
            </ol>
        </nav>          
    </div>
</div><!-- .nk-block-head -->