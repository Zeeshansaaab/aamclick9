@props([
    'user'
])
<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg toggle-screen-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
        <div class="card-inner">
            <div class="user-card">
                <div class="user-avatar bg-primary">
                    <span>{{nameAronnym($user->name)}}</span>
                </div>
                <div class="user-info">
                    <span class="lead-text">{{$user->name}}</span>
                    <span class="sub-text">{{$user->uuid}}</span>
                </div>
                <div class="user-action">
                    <div class="dropdown">
                        <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="link-list-opt no-bdr">
                                <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- .user-card -->
        </div><!-- .card-inner -->
        <div class="card-inner p-0">
            <ul class="link-list-menu">
                <li><a class="{{Route::is('profile.show') ? 'active' : '' }}" href="{{route('profile.show')}}"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                <li><a class="{{Route::is('profile.login-logs') ? 'active' : '' }}"  href="{{route('profile.login-logs')}}"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
            </ul>
        </div><!-- .card-inner -->
    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 450px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none;"></div></div></div><!-- .card-inner-group -->
</div><!-- card-aside -->