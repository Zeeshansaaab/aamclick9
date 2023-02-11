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
        {{isset($styles) ? $styles : ''}}
    </head>
    <body class="nk-body bg-white npc-general pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <div class="nk-wrap-nosidebar">
                    <div class="nk-header nk-header-fluid nk-header-fixed is-light">
                        <div class="container-fluid">
                            <div class="nk-header-wrap" style="height: 60px;">
                                <div class="nk-header-brand">
                                    <a href="{{ route('dashboard') }}" class="logo-link">
                                        <x-application-logo width="100px"/>
                                    </a>
                                </div>
                                <div class="nk-header-tools">
                                    <nav class="navbar navbar-expand-lg">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                          <span class="navbar-toggler-icon"></span>
                                        </button>
                                      
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                          <ul class="navbar-nav mr-auto">
                                            <li class="nav-item active">
                                              <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" href="#">About</a>
                                            </li>
                                            <li class="nav-item active">
                                              <a class="nav-link" href="#">Pricing</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" href="#">About</a>
                                            </li>
                                            <li class="nav-item active">
                                              <a class="nav-link" href="#">Blog</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" href="#">Contact</a>
                                            </li>
                                            @guest
                                              <li class="nav-item">
                                                <a class="nav-link" href="{{route('login')}}">Login</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" href="{{route('register')}}">Register</a>
                                              </li>
                                             @else 
                                             <li class="nav-item">
                                              <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                                            </li>
                                            @endguest
                                          </ul>
                                        </div>
                                    </nav>
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
        <script src="{{ asset('js/helper.js') }}" ></script>
        <script src="{{ asset('js/main.js') }}" ></script>
    </body>
</html>
