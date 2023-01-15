@props([
    'transaction'
])
<div class="nk-tb-item">
    <div class="nk-tb-col">
        <div class="nk-tnx-type">
            <div class="nk-tnx-type-icon @if($transaction->type == 'credit') bg-success-dim text-success @elseif($transaction->trx_type == '-') bg-danger-dim text-danger @endif">
                <em class="icon ni ni-arrow-up-right"></em>
            </div>
            <div class="nk-tnx-type-text">
                <span class="tb-lead">{{ $transaction->details }}</span>
                <span class="tb-date">{{ $transaction->created_at->format('d/m/Y h:i:s a') }}</span>
            </div>
        </div>
    </div>
    <div class="nk-tb-col tb-col-lg">
        <span class="tb-lead-sub">{{ $transaction->trx }}</span>
        <span class="badge badge-dot @if($transaction->type == 'credit') badge-success @else badge-danger  @endif text-capitalize">{{ $transaction->type }}</span>
    </div>
    <div class="nk-tb-col text-right">
        <span class="tb-amount">{{ $transaction->trx_type }} {{ currency($transaction->amount, true) }} <span>{{ cur_text() }}</span></span>
        <span class="tb-amount-sm">{{ currency($transaction->post_balance) }}</span>
    </div>
</div><!-- .nk-tb-item -->