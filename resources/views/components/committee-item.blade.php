<table class="table table-orders">
    <thead class="tb-odr-head">
        <tr class="tb-odr-item">
            <th class="tb-odr-info">
                <span class="tb-odr-id">Name</span>
                <span class="tb-odr-date d-none d-md-inline-block">Date</span>
            </th>
            <th class="tb-odr-amount">
                <span class="tb-odr-total">Amount</span>
                <span class="tb-odr-status d-none d-md-inline-block">Status</span>
            </th>
            <th class="tb-odr-action">&nbsp;</th>
        </tr>
    </thead>
    <tbody class="tb-odr-body">
        @forelse ($committees as $committee)
            <tr class="tb-odr-item">
                <td class="tb-odr-info">
                    <span class="tb-odr-id"><a href="html/invoice-details.html">{{ $committee->plan->name }}</a></span>
                    <span class="tb-odr-date">{{ $committee->created_at }}</span>
                </td>
                <td class="tb-odr-amount">
                    <span class="tb-odr-total">
                        <span class="amount">{{ $committee->plan->price }}</span>
                    </span>
                    <span class="tb-odr-status">
                        <span class="badge badge-dot text-capitalize badge-{{ $committee->status == 'pending' ? 'warning' : 'success'}}">{{ $committee->status }}</span>
                    </span>
                </td>
                <td class="tb-odr-action">
                    <div class="tb-odr-btns d-none d-sm-inline">
                        <a href="{{ route('reports.payments', ['credit', 'committee']) }}?uuid={{ $committee->plan->uuid }}" class="btn btn-dim btn-sm btn-primary">View Installments</a>
                    </div>
                </td>
            </tr><!-- .tb-odr-item -->
        @empty
            <tr>
                <td colspan="3" class="text-center">No Data found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
{{ $committees->links() }}
{{-- Pagination End --}}