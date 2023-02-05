<table class="table table-orders border">
    <thead class="tb-odr-head">
        <tr class="tb-odr-item">
            <th class="tb-odr-info">
                <span class="tb-odr-id">Name</span>
                <span class="tb-odr-date d-none d-md-inline-block">Phone</span>
            </th>
            <th class="tb-odr-amount">
                <span class="tb-odr-total">Email</span>
                <span class="tb-odr-status d-none d-md-inline-block">Address</span>
            </th>
            <th class="tb-odr-amount">
                <span class="tb-odr-total">Amount</span>
                <span class="tb-odr-status d-none d-md-inline-block">Status</span>
            </th>
        </tr>
    </thead>
    <tbody class="tb-odr-body">
        @forelse ($installments as $installment)
            <tr class="tb-odr-item">
                <td class="tb-odr-info">
                    <span class="tb-odr-id"><a href="#">{{ $installment->name }}</a></span>
                    <span class="tb-odr-date">{{ $installment->phone }}</span>
                </td>
                <td class="tb-odr-info">
                    <span class="tb-odr-total">{{ $installment->email }}</span>
                    <span class="tb-odr-info">{{ $installment->address }}</span>
                </td>
                <td class="tb-odr-amount">
                    <span class="tb-odr-total">
                        <span class="amount">{{ $installment->amount }}</span>
                    </span>
                    <span class="tb-odr-status">
                        <span class="badge badge-dot text-capitalize badge-{{ $installment->status->cssClass()}}">{{ $installment->status->label() }}</span>
                    </span>
                </td>
            </tr><!-- .tb-odr-item -->
        @empty
            <tr>
                <td colspan="3" class="text-center">No Data found</td>
            </tr>
        @endforelse
    </tbody>
</table>