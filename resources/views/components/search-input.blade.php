@props([
    'url',
    'placeholder'
])
<div class="card-search search-wrap" data-search="search">
    <div class="card-body">
        <div class="search-content">
            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search">
                <em class="icon ni ni-arrow-left"></em></a>
            <input type="text" class="form-control border-transparent form-focus-none" id="search-input" placeholder="{{ $placeholder }}">
            <button class="search-submit btn btn-icon" data-url="{{ route($url) }}"><em class="icon ni ni-search"></em></button>
        </div>
    </div>
</div><!-- .card-search -->