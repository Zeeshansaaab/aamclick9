@props([
    'payments'
])
<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-tnx">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span>Details</span></div>
            <div class="nk-tb-col tb-col-xxl"><span>Source</span></div>
            <div class="nk-tb-col text-right"><span>Amount</span></div>
            <div class="nk-tb-col nk-tb-col-status"><span class="sub-text d-none d-md-block">Status</span></div>
        </div><!-- .nk-tb-item -->
        @forelse ($payments as $payment)
            <x-payment-item :payment="$payment" />
        @empty
        <div class="text-center my-2 ">
            No Data found
        </div>
        @endforelse
    </div>
</div>

{{ $payments->links() }}
