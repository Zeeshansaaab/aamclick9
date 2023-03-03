<x-app-layout>
    <x-slot name="title">Profile</x-slot>

    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Profile" title="Profile" :links="['dashboard' => 'dashboard']"/>
    </x-slot>

    <x-slot name="header">
    </x-slot>
    <div class="card card-bordered">
        <div class="card-aside-wrap">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Personal Information</h4>
                            <div class="nk-block-des">
                                <p>Basic info, like your name and address, that you use on Our Platform.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content align-self-start d-lg-none">
                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="nk-data data-list">
                        <div class="data-head">
                            <h6 class="overline-title">Basics</h6>
                        </div>
                        <div class="data-item" data-action="{{route('profile.edit', [$user->uuid])}}" data-method="get" data-act="modal-form" data-backend-modal="profile-edit">
                            <div class="data-col">
                                <span class="data-label">Name</span>
                                <span class="data-value">{{$user->name}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item -->
                        <div class="data-item" data-action="{{route('profile.edit', [$user->uuid])}}" data-method="get" data-act="modal-form" data-backend-modal="profile-edit">
                            <div class="data-col">
                                <span class="data-label">AAM ID</span>
                                <span class="data-value">{{$user->uuid}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item -->
                        <div class="data-item" data-action="{{route('profile.edit', [$user->uuid])}}" data-method="get" data-act="modal-form" data-backend-modal="profile-edit">
                            <div class="data-col">
                                <span class="data-label">Email</span>
                                <span class="data-value">{{$user->email}}</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                        </div><!-- data-item -->
                        <div class="data-item" data-action="{{route('profile.edit', [$user->uuid])}}" data-method="get" data-act="modal-form" data-backend-modal="profile-edit">
                            <div class="data-col">
                                <span class="data-label">Phone Number</span>
                                <span class="data-value text-soft">{{$user->mobile}}</span>
                            </div>
                            <div class="data-col data-col-end">
                                <span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item -->
                        {{-- <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">Date of Birth</span>
                                <span class="data-value">29 Feb, 1986</span>
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item --> --}}
                        <div class="data-item" data-action="{{route('profile.edit', [$user->uuid])}}" data-method="get" data-act="modal-form" data-backend-modal="profile-edit" data-tab-target="#address">
                            <div class="data-col">
                                <span class="data-label">Address</span>
                                @if($user->address)
                                    <span class="data-value text-capitalize">{{$user->address->address}},<br>{{$user->address->state}}, {{$user->address->country}}</span>
                                @endif
                            </div>
                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                        </div><!-- data-item -->
                    </div><!-- data-list -->
                </div><!-- .nk-block -->
            </div>
            <x-users.profile-sidebar :user="$user"/>
        </div><!-- .card-aside-wrap -->
    </div>
</x-app-layout>