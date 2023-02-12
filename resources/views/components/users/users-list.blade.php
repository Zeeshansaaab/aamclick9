@props([
    'users' => $users
])

<div class="card-inner p-0">
    <table class="table table-tranx">
        <thead>
            <tr class="tb-tnx-head">
                <th class="tb-tnx-id"><span class="">#</span></th>
                <th class="tb-tnx-info">
                    <span class="tb-tnx-desc d-none d-sm-inline-block">
                        <span>Name</span>
                    </span>
                    <span class="tb-tnx-date d-md-inline-block d-none">
                        <span class="d-md-none">Amount</span>
                        <span class="d-none d-md-block">
                            <span>Deposit</span>
                            <span>Profit</span>
                        </span>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <x-users.user-item :user="$user" :index="$loop->index + 1"></x-users.user-item>
            @endforeach
        </tbody>
    </table>
</div><!-- .card-inner -->

{{-- Paginations --}}
{{ $users->withQueryString()->links() }}
{{-- Paginations End --}}