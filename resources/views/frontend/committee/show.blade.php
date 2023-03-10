@php
    $cur_text = cur_text();
@endphp
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
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><span class="w-50" style="font-size: 12px;">Validity</span> - <span class="ml-auto" style="font-size: 12px;">{{ $plan->validity }}</span></li>
                            <li><span class="w-50" style="font-size: 12px;">Amount Return</span> - <span class="ml-auto" style="font-size: 12px;">{{ $plan->amount_return }}</span></li>
                            <li><span class="w-50" style="font-size: 12px;">Total Members</span> - <span class="ml-auto" style="font-size: 12px;">{{ $plan->total_members }}</span></li>
                            <li><span class="w-50" style="font-size: 12px;">Current Members</span> - <span class="ml-auto" style="font-size: 12px;" id="total-members">{{ $plan->members_count }}</span></li>
                        </ul>
                    </div>
                    <div class="pricing-amount">
                        <div class="amount">{{ currency($plan->price) }}</div>
                    </div>
                    <div class="pricing-action">
                        <a data-act="ajax-page" data-method="post" data-content="#{{\Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($plan->starting_date)) ? 'plans' : 'total-members'}}" data-post-plan_id="{{ $plan->id }}" data-action-url="{{ route('committees.store') }}" data-swal-content="{{\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($plan->starting_date))}}" class="btn btn-primary text-white eg-swal-success">
                            @if(auth()->user()->committees()->where('plan_id', $plan->id)->count() > 0) Show Committe Number @else Select Plan @endif</a>
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endforeach

