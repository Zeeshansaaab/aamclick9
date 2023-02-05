<div class="row g-gs justify-content-center">
    <div class="col-md-4">
        <div class="card card-bordered card-full">
            <div class="card-inner">
                <div class="card-title-group align-start mb-0">
                    <div class="card-title">
                        <h6 class="subtitle">Committee Number</h6>
                    </div>
                    <div class="card-tools">
                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="" data-original-title="Committee Number"></em>
                    </div>
                </div>
                @if($plan->committee_number)
                    <span class="amount">Your Committee Number is:</span><br>
                    <div class="card-amount justify-content-center" style="margin: 25px;">
                        <h1 style="font-size: 7rem;" class="committee-number">{{$plan->committee_number}}</h1>
                    </div>
                @endif
                @if(\Carbon\Carbon::parse($plan->plan->starting_date)->lessThanOrEqualTo(\Carbon\Carbon::now()) && !$plan->committee_number)
                    <div class="card-footer bg-white">
                        <a class="btn btn-primary fw-bold text-white" data-act="ajax-page" data-method="post" data-content="#plans" data-post-id="{{ $plan->id }}" data-action-url="{{ route('committees.get-committee-number') }}" class="btn btn-primary text-white eg-swal-success">Get Your Committee Number</a>
                    </div>
                @endif
            </div>
        </div><!-- .card -->
    </div>
</div>