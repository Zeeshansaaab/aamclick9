@component('admin.layout.app')
    <x-slot name="title">Plans</x-slot>

    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Plans" title="Plans" />
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    {{-- <h4 class="nk-block-title fw-normal text-capitalize">Plans</h4> --}}
                    <div class="nk-block-des">
                        <p></p>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    {{-- <li>
                    <a href="{{ route('payment', 'credit') }}" class="btn btn-primary"><span>Deposit</span> <em class="icon ni ni-arrow-long-right"></em></a>
                </li>
                <li><a href="{{ route('payment', 'debit') }}" class="btn btn-white btn-light"><span>Withdraw</span> <em class="icon ni ni-arrow-long-right d-none d-sm-inline-block"></em></a></li> --}}
                </ul>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner-group">
                <div class="card-inner position-relative card-tools-toggle">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h5 class="title">Plans</h5>
                        </div>
                        <div class="card-tools me-n1">
                            <ul class="btn-toolbar gx-1">
                                <li class="toggle-close">
                                    <a href="#" class="btn btn-icon btn-trigger toggle "
                                        data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a></li>
                                <li>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-trigger btn-icon dropdown-toggle "
                                            data-bs-toggle="dropdown">
                                            <div class="dot dot-primary"></div><em class="icon ni ni-filter-alt"></em>
                                        </a>
                                        <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head"><span class="sub-title dropdown-title">Filter
                                                    Users</span>
                                                <div class="dropdown"><a href="#" class="btn btn-sm btn-icon"><em
                                                            class="icon ni ni-more-h"></em></a></div>
                                            </div>
                                            <div class="dropdown-body dropdown-body-rg">
                                                <div class="row gx-6 gy-3">
                                                    <div class="col-6">
                                                        <div class="custom-control custom-control-sm custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                id="hasBalance"><label class="custom-control-label"
                                                                for="hasBalance"> Have Balance</label></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="custom-control custom-control-sm custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                id="hasKYC"><label class="custom-control-label"
                                                                for="hasKYC"> KYC Verified</label></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group"><label
                                                                class="overline-title overline-title-alt">Role</label><select
                                                                class="form-select js-select2 select2-hidden-accessible"
                                                                data-select2-id="4" tabindex="-1" aria-hidden="true">
                                                                <option value="any" data-select2-id="6">Any Role</option>
                                                                <option value="investor">Investor</option>
                                                                <option value="seller">Seller</option>
                                                                <option value="buyer">Buyer</option>
                                                            </select><span
                                                                class="select2 select2-container select2-container--default"
                                                                dir="ltr" data-select2-id="5"
                                                                style="width: auto;"><span class="selection"><span
                                                                        class="select2-selection select2-selection--single"
                                                                        role="combobox" aria-haspopup="true"
                                                                        aria-expanded="false" tabindex="0"
                                                                        aria-disabled="false"
                                                                        aria-labelledby="select2-hbmr-container"><span
                                                                            class="select2-selection__rendered"
                                                                            id="select2-hbmr-container" role="textbox"
                                                                            aria-readonly="true" title="Any Role">Any
                                                                            Role</span><span
                                                                            class="select2-selection__arrow"
                                                                            role="presentation"><b
                                                                                role="presentation"></b></span></span></span><span
                                                                    class="dropdown-wrapper"
                                                                    aria-hidden="true"></span></span></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group"><label
                                                                class="overline-title overline-title-alt">Status</label><select
                                                                class="form-select js-select2 select2-hidden-accessible"
                                                                data-select2-id="7" tabindex="-1" aria-hidden="true">
                                                                <option value="any" data-select2-id="9">Any Status
                                                                </option>
                                                                <option value="active">Active</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="suspend">Suspend</option>
                                                                <option value="deleted">Deleted</option>
                                                            </select><span
                                                                class="select2 select2-container select2-container--default"
                                                                dir="ltr" data-select2-id="8"
                                                                style="width: auto;"><span class="selection"><span
                                                                        class="select2-selection select2-selection--single"
                                                                        role="combobox" aria-haspopup="true"
                                                                        aria-expanded="false" tabindex="0"
                                                                        aria-disabled="false"
                                                                        aria-labelledby="select2-qqvy-container"><span
                                                                            class="select2-selection__rendered"
                                                                            id="select2-qqvy-container" role="textbox"
                                                                            aria-readonly="true" title="Any Status">Any
                                                                            Status</span><span
                                                                            class="select2-selection__arrow"
                                                                            role="presentation"><b
                                                                                role="presentation"></b></span></span></span><span
                                                                    class="dropdown-wrapper"
                                                                    aria-hidden="true"></span></span></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group"><button type="button"
                                                                class="btn btn-secondary">Filter</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-foot between"><a class="clickable" href="#">Reset
                                                    Filter</a><a href="#">Save Filter</a></div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown"><a href="#"
                                            class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown"><em
                                                class="icon ni ni-setting"></em></a>
                                        <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                            <ul class="link-check">
                                                <li><span>Show</span></li>
                                                <li class="active"><a href="#">10</a></li>
                                                <li><a href="#">20</a></li>
                                                <li><a href="#">50</a></li>
                                            </ul>
                                            <ul class="link-check">
                                                <li><span>Order</span></li>
                                                <li class="active"><a href="#">DESC</a></li>
                                                <li><a href="#">ASC</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <x-search-input
                            url="{{ route('reports.transactions.table') }}?remark={{ request()->query('remark') }}&&reward={{ request()->query('reward') }}"
                            placeholder="Search by trx or remark" />
                    </div>
                </div>


                <div id="table">

                </div>
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div>
    <x-slot name="scripts">
        <script>
            
        </script>
    </x-slot>
@endcomponent
