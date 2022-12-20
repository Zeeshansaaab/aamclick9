
<!-- main header @s -->
<div class="nk-header nk-header-fluid nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="html/crypto/index.html" class="logo-link">
                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                    <span class="nio-version">{{ config('app.name') }}</span>
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
                                    <li><a href="html/crypto/profile.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a href="html/crypto/profile-security.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                    <li><a href="html/crypto/profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
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
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                <a href="#">Mark All as Read</a>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    {{-- <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon">
                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                            <div class="nk-notification-time">2 hrs ago</div>
                                        </div>
                                    </div><!-- .dropdown-inner --> --}}
                                </div>
                            </div><!-- .nk-dropdown-body -->
                            <div class="dropdown-foot center">
                                <a href="#">View All</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- main header  -->