@props([
    'users' => $users
])

<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">User</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Verified</span></div>
            {{-- <div class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span></div> --}}
            <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
        </div><!-- .nk-tb-item -->
        @foreach($users as $user)
            <div class="nk-tb-item">
                {{-- Full name --}}
                <div class="nk-tb-col">
                    <a href="#">
                        <div class="user-card">
                            <div class="user-avatar bg-primary">
                                <span>AB</span>
                            </div>
                            <div class="user-info">
                                <span class="tb-lead">{{ $user->name }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                <span>{{ $user->email }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- Verified --}}
                <div class="nk-tb-col tb-col-lg">
                    <ul class="list-status">
                        <li><em class="icon ni @if($user->email_verified_at) text-success ni-check-circle @else ni-alert-circle @endif"></em> <span>Email</span></li>
                        {{-- <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li> --}}
                    </ul>
                </div>
                {{-- Last login --}}
                {{-- <div class="nk-tb-col tb-col-lg">
                    <span>10 Feb 2020</span>
                </div> --}}

                <div class="nk-tb-col tb-col-md">
                    <span class="tb-status {{ $user->status->cssClass() }}">{{ $user->status->label() }}</span>
                </div>
            </div><!-- .nk-tb-item -->
        @endforeach
    </div><!-- .nk-tb-list -->
</div><!-- .card-inner -->

{{-- Paginations --}}
{{ $users->withQueryString()->links() }}
{{-- Paginations End --}}