<table class="table table-orders border">
    <thead class="tb-odr-head">
        <tr class="tb-odr-item">
            <th class="tb-odr-info">
                <span class="tb-odr-id">From</span>
            </th>
            <th><span class="tb-odr-date d-md-inline-block">Date</span></th>
            <th class="tb-odr-amount">
                <span class="tb-odr-total">level</span>
            </th>
            <th class="tb-odr-amount">
                <span class="tb-odr-total">Amount</span>
            </th>
        </tr>
    </thead>
    <tbody class="tb-odr-body">
        @foreach ($commissions as $commission)
            <tr class="tb-odr-item">
                <td class="tb-odr-info">
                    <span class="tb-odr-id text-capitalize"><a href="#">{{ $commission->from->name }}</a></span>
                </td>
                <td><span class="tb-odr-id text-capitalize">{{ formatDate($commission->created_at) }}</span></td>
                <td class="tb-odr-info">
                    <span class="tb-odr-date">{{ $commission->level }}</span>
                </td>
                <td class="tb-odr-amount">
                    <span class="tb-odr-total">{{ currency($commission->transaction->amount) }}</span>

                </td>
            </tr><!-- .tb-odr-item -->
        @endforeach
    </tbody>
</table>

{{-- Pagination --}}
{{ $commissions->links() }}
{{-- Pagination End --}}