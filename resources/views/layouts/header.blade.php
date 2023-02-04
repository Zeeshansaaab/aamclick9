
<!-- main header @s -->
@php
    $totalNotifications = auth()->user()->unreadNotifications()->count()
@endphp
<div class="nk-header nk-header-fluid nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="{{ route('dashboard') }}" class="logo-link">
                    <x-application-logo width="100px"/>
                </a>
            </div>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-status {{ auth()->user()->email_verified_at ? 'user-status-verified' : 'user-status-unverified' }}">{{ auth()->user()->email_verified_at ? 'Verified' : 'Unverified' }}</div>
                                    <div class="user-name dropdown-indicator">{{ auth()->user()->name }}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ auth()->user()->name }}</span>
                                        <span class="sub-text">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    {{-- <li><a href="html/crypto/profile.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a href="html/crypto/profile-security.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                    <li><a href="html/crypto/profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li> --}}
                                    <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <form method="post" action="{{ route('logout') }}">
                                            @csrf
                                            <a style="cursor: pointer;" onclick="this.parentNode.submit();"> 
                                                <em class="icon ni ni-signout">
                                            </em><span>Sign out</span></a></a>
                                          </form>
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown notification-dropdown mr-n1">
                        <a href="javascript:void(0)" class="dropdown-toggle nk-quick-nav-icon notification-dropdown-trigger" >
                            <div 
                            class="icon-status icon-status-{{ $totalNotifications > 0 ? 'danger' : 'light' }}">
                                <em class="icon ni ni-bell"></em>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1" style="" id="notifications-list">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                <a href="javascript:void(0)" class="markAllasread">Mark All as Read</a>
                            </div>
                            <div id="notification-dropdown-items">
                                
                            </div>
                            <div class="dropdown-foot view-all">
                                <a href="javascript:void(0)" style="width: 100%; text-align: center;">View All</a>
                            </div>
                        </div>
                        
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- main header  -->