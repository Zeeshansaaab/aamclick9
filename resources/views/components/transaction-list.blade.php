@props([
    'transactions'
])
<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-tnx">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span>Details</span></div>
            <div class="nk-tb-col tb-col-xxl"><span>Source</span></div>
            <div class="nk-tb-col tb-col-lg"><span>TRX</span></div>
            <div class="nk-tb-col text-right"><span>Amount</span></div>
        </div><!-- .nk-tb-item -->
        @foreach ($transactions as $transaction)
            <div class="nk-tb-item">
                <div class="nk-tb-col">
                    <div class="nk-tnx-type">
                        <div class="nk-tnx-type-icon @if($transaction->trx_type == 'credit')bg-success-dim text-success @elseif($transaction->trx_type == '-') bg-danger-dim text-danger @endif">
                            <em class="icon ni ni-arrow-up-right"></em>
                        </div>
                        <div class="nk-tnx-type-text">
                            <span class="tb-lead">{{ $transaction->remark }}</span>
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
        @endforeach
       
    </div><!-- .nk-tb-list -->
</div>
{{-- Pagination --}}
{{ $transactions->links() }}
{{-- Pagination End --}}