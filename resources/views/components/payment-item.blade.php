@props([
    'payment'
])
<div class="nk-tb-item">
    <div class="nk-tb-col">
        <div class="nk-tnx-type">
            <div class="nk-tnx-type-icon @if($payment->transaction->type == 'credit') bg-success-dim text-success @elseif($payment->transaction->trx_type == '-') bg-danger-dim text-danger @endif">
                <em class="icon ni ni-arrow-up-right"></em>
            </div>
            <div class="nk-tnx-type-text">
                <span class="tb-lead">{{ $payment->gateway->name }}</span>
                <span class="tb-date">{{ $payment->created_at->format('d/m/Y h:i:s a') }}</span>
            </div>
        </div>
    </div>
    <div class="nk-tb-col text-right">
        <span class="tb-amount">{{ currency($payment->transaction->amount, true) }} <span>{{ $payment->gateway->currency }}</span></span>
    </div>
    <div class="nk-tb-col nk-tb-col-status">
        <div class="dot dot-{{ $payment->transaction->status->cssClass() }} d-md-none"></div>
        <span class="badge badge-sm badge-dim badge-outline-{{ $payment->transaction->status->cssClass() }} d-none d-md-inline-flex">{{ $payment->transaction->status->label() }}</span>
    </div>
</div><!-- .nk-tb-item -->