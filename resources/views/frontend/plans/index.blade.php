@php
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="title">Plans</x-slot>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Plans" title="Plans" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal mb-2">Plans</h4>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    
        @foreach ($plans as $plan)
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
                                    <div class="col-12 text-center">
                                        <span class="h6 fw-500">{{ $plan->min_profit_percent }} to {{ $plan->max_profit_percent }} %</span>
                                        <span class="sub-text">Estimated profit</span>
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
                                @foreach ($plan->levels->where('type', 'deposit_commission')->values() as $level)
                                    <li><span class="w-50">Level - {{$level->level}}</span> - <span class="ml-auto">{{ $level->percentage }} %</span></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-3">
                        <div class="pricing-title text-center">
                                <p class="card-title title">Profit bonus</p>
                            </div>
                            <ul class="">
                                @foreach ($plan->levels->where('type', 'profit_bonus')->values() as $level)
                                    <li><span class="w-50">Level - {{$level->level}}</span> - <span class="ml-auto">{{ $level->percentage }} %</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
</x-app-layout>