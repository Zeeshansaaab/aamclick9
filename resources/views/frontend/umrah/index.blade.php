@php
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="title">Umrah Packages</x-slot>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Umrah packages" title="Plans" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal mb-2">Umrah Packages</h4>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    
    <div id="plans">
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-md-4 col-sm-12 mt-3">
                    <div class="card card-bordered pricing text-center">
                        <div class="pricing-body">
                            <div class="pricing-media">
                                <img src="/images/svg/plan-s1.svg" alt="">
                            </div>
                            <div class="pricing-title w-220px mx-auto">
                                <h5 class="title">{{ $plan->name }}</h5>
                            </div>
                            <div class="pricing-amount">
                                <div class="amount">{{ currency($plan->price) }}</div>
                            </div>
                            <div class="pricing-action">
                                <a 
                                    href="{{route('payment', 'deposit')}}?deposit_type=umrah&amount={{$plan->price}}" 
                                    class="btn btn-primary">
                                    Apply
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

