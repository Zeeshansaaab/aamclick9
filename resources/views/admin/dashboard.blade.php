
@component('admin.layout.app')
    
<x-slot name="title">Dashboard</x-slot>

<x-slot name="breadcrumb">
    <x-breadcrumb currentPage="Dashboard" title="Dashboard"/>
</x-slot>

<x-slot name="header">
    <div class="nk-block-between-md g-4">
        <div class="nk-block-head">
            <div class="nk-block-head-sub"><span>Welcome!</span></div>
            <div class="nk-block-head-content">
                <h2 class="nk-block-title fw-normal text-capitalize">{{ auth()->user()->name }}</h2>
                <div class="nk-block-des"><p></p></div>
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
@endcomponent
