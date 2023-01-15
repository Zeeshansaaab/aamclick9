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
           <x-transaction-item :transaction="$transaction" />
        @endforeach
       
    </div><!-- .nk-tb-list -->
</div>
{{-- Pagination --}}
{{ $transactions->links() }}
{{-- Pagination End --}}