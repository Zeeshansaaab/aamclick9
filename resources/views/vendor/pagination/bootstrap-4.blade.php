
@if ($paginator->hasPages())
    <div class="card-inner">
        <div class="nk-block-between-md g-3">
            <div class="g">
                <ul class="pagination pagination-sm justify-content-center justify-content-md-start">
                    @if ($paginator->onFirstPage())
                        <li class="page-item"><span class="page-link" aria-hidden="true">&lsaquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
                    @endif
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if($loop->index < 2)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif                </ul><!-- .pagination -->
            </div>
            {{-- <div class="g">
                <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                    <div>Page</div>
                    <div>
                        <select class="form-select select2-hidden-accessible" data-search="on" data-dropdown="xs center" data-select2-id="10" tabindex="-1" aria-hidden="true">
                            <option value="page-1" data-select2-id="12">1</option>
                            <option value="page-2">2</option>
                            <option value="page-4">4</option>
                            <option value="page-5">5</option>
                            <option value="page-6">6</option>
                            <option value="page-7">7</option>
                            <option value="page-8">8</option>
                            <option value="page-9">9</option>
                            <option value="page-10">10</option>
                            <option value="page-11">11</option>
                            <option value="page-12">12</option>
                            <option value="page-13">13</option>
                            <option value="page-14">14</option>
                            <option value="page-15">15</option>
                            <option value="page-16">16</option>
                            <option value="page-17">17</option>
                            <option value="page-18">18</option>
                            <option value="page-19">19</option>
                            <option value="page-20">20</option>
                        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="11" style="width: 38.6667px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-zp48-container"><span class="select2-selection__rendered" id="select2-zp48-container" role="textbox" aria-readonly="true" title="1">1</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                    </div>
                    <div>OF 102</div>
                </div>
            </div><!-- .pagination-goto --> --}}
        </div><!-- .nk-block-between -->
    </div><!-- .card-inner -->
@endif