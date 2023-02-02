@php
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="title">Committee Plans</x-slot>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Committee plans" title="Plans" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title fw-normal mb-2">Committee Plans</h4>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    
    <div id="plans">
        @foreach ($plans as $plan)
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="card card-bordered pricing text-center">
                        <div class="pricing-body">
                            <div class="pricing-media">
                                <img src="/images/svg/plan-s1.svg" alt="">
                            </div>
                            <div class="pricing-title w-220px mx-auto">
                                <h5 class="title">Name: {{ $plan->name }}</h5>
                            </div>
                            <div class="pricing-amount">
                                <div class="amount">{{ currency($plan->price) }}</div>
                            </div>
                            <div class="pricing-action">
                                <a data-act="ajax-page" data-content="#plans" data-method="get"  data-action-url="{{ route('committees.show', $plan->uuid) }}" href="javascript:void(0)" class="btn btn-primary eg-swal-success">Show all plans</a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>

