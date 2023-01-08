@php
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :currentPage="$title" title="Plans" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal mb-2">{{ $title }}</h4>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    
        @foreach ($plans as $plan)
            @if ($title == 'Plans')
            <div class="card card-bordered pricing">
                <div class="pricing-head">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="pricing-title">
                                <h4 class="card-title title">{{ $plan->name }}</h4>
                                <p class="sub-text">{{ $plan->description }}</p>
                            </div>
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="h6 fw-500">{{ $plan->min_profit_percent }} to {{ $plan->max_profit_percent }} %</span>
                                        <span class="sub-text">Estimated profit</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="h6 fw-500">{{ $plan->validity }}</span>
                                        <span class="sub-text">Amount return</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="pricing-title text-center">
                                <p class="card-title title">Detail</p>
                            </div>
                            <ul class="">
                                <li><span class="w-50">Min Deposit</span> - <span class="ml-auto">{{ currency($plan->min_price) }}</span></li>
                                <li><span class="w-50">Max Deposit</span> - <span class="ml-auto">{{ currency($plan->max_price) }}</span></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="pricing-title text-center">
                                <p class="card-title title">Deposit Commission</p>
                            </div>
                            <ul class="">
                                <li><span class="w-50">Level-1</span> - <span class="ml-auto">{{ currency($plan->min_price) }}</span></li>
                                <li><span class="w-50">Level-2</span> - <span class="ml-auto">{{ currency($plan->max_price) }}</span></li>
                                <li><span class="w-50">Level-3</span> - <span class="ml-auto">{{ currency($plan->min_price) }}</span></li>
                                <li><span class="w-50">Level-4</span> - <span class="ml-auto">{{ currency($plan->max_price) }}</span></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="pricing-title text-center">
                                <p class="card-title title">Profit bonus</p>
                            </div>
                            <ul class="">
                                <li><span class="w-50">Level-1</span> - <span class="ml-auto">{{ currency($plan->min_price) }}</span></li>
                                <li><span class="w-50">Level-2</span> - <span class="ml-auto">{{ currency($plan->max_price) }}</span></li>
                                <li><span class="w-50">Level-3</span> - <span class="ml-auto">{{ currency($plan->min_price) }}</span></li>
                                <li><span class="w-50">Level-4</span> - <span class="ml-auto">{{ currency($plan->max_price) }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @elseif ($title == 'Committee Plans') 
            <div class="row">
                <div class="col-md-4 col-sm-12">
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
                                <a href="#" class="btn btn-primary">Select Plan</a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
                    
            @endif
        @endforeach
</x-app-layout>