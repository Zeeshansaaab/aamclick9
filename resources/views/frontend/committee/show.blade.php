@php
    $cur_text = cur_text();
@endphp
@foreach ($plans as $plan)
    <div class="col-md-4 col-sm-12">
        <div class="card card-bordered pricing text-center">
            <div class="pricing-body">
                <div class="pricing-media">
                    <img src="/images/svg/plan-s1.svg" alt="">
                </div>
                <div class="pricing-title w-220px mx-auto">
                    <h5 class="title">Name: {{ $plan->name }}</h5>
                </div>
                <div class="pricing-body">
                    <ul class="pricing-features">
                        <li><span class="w-50" style="font-size: 12px;">Validity</span> - <span class="ml-auto">{{ $plan->validity }}</span></li>
                        <li><span class="w-50" style="font-size: 12px;">Amount Return</span> - <span class="ml-auto">{{ $plan->amount_return }}</span></li>
                        <li><span class="w-50" style="font-size: 12px;">Total Members</span> - <span class="ml-auto">{{ $plan->total_members }}</span></li>
                        <li><span class="w-50" style="font-size: 12px;">Current Members</span> - <span class="ml-auto" id="total-members">{{ $plan->members_count }}</span></li>
                    </ul>
                </div>
                <div class="pricing-amount">
                    <div class="amount">{{ currency($plan->price) }}</div>
                </div>
                <div class="pricing-action">
                    <a data-act="ajax-page" data-method="post" data-content="#total-members" data-post-plan_id="{{ $plan->id }}" data-action-url="{{ route('committees.store') }}" data-swal-content="true" class="btn btn-primary text-white eg-swal-success">Select Plan</a>
                </div>
            </div>
        </div> 
    </div>
@endforeach

