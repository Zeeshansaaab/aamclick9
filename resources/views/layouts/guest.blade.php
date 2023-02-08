<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <!-- Scripts -->
        {{-- <link rel="stylesheet" href="{{ mix('css/theme.css') }}" /> --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    </head>
    <body class="nk-body bg-white npc-general pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <div class="nk-wrap-nosidebar">
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
                                                        <div class="user-status "></div>
                                                        <div class="user-name dropdown-indicator"></div>
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
                                                            <span class="lead-text"></span>
                                                            <span class="sub-text"></span>
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
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-content nk-content-fluid">
                        <div class="nk-content-body">
                            <div class="nk-block">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}" ></script>
        <script src="{{ mix('js/theme.js') }}"></script>
    </body>
</html>
