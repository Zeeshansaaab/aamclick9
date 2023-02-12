@props([
  'header' => true
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AAM Click') }}</title>
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <!-- Scripts -->
        {{-- <link rel="stylesheet" href="{{ mix('css/theme.css') }}" /> --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
        {{isset($styles) ? $styles : ''}}

        <style>
          .logo-img-lg{
            width: 180px
          }
          /* width */
          ::-webkit-scrollbar {
            width: 10px;
          }

          /* Track */
          ::-webkit-scrollbar-track {
            background: #f1f1f1;
          }

          /* Handle */
          ::-webkit-scrollbar-thumb {
            background: #888;
          }

          /* Handle on hover */
          ::-webkit-scrollbar-thumb:hover {
            background: #555;
          }
          .form-container{
            width: 40%;
            margin: auto;
            margin-top: 80px;

          }
          @media screen and (max-width: 990px) {
            .form-container {
              width: 80%;
              margin: auto;
              margin-top: 80px;

            }
            .show{
              position: relative;
              top: 162px;
              background: #006cff;
              border-radius: 3px;
              width: 164px;
              right: 70px;
            }
            .navbar-toggler{
              position: fixed;
              right: 24px;
            }
            .show .navbar-nav .nav-item .nav-link{
              color:white;
            }
          }
        </style>
    </head>
    <body class="nk-body bg-white npc-general pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <div class="nk-wrap-nosidebar">
                    @if($header)
                    <div class="nk-header nk-header-fluid nk-header-fixed is-light">
                        <div class="container-fluid">
                            <div class="nk-header-wrap" style="height: 80px;">
                                <div class="nk-header-brand">
                                    <a href="{{ route('home') }}" class="logo-link">
                                        <x-application-logo width="100px"/>
                                    </a>
                                </div>
                                <div class="nk-header-tools">
                                    <nav class="navbar navbar-expand-lg navbar-light">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                          <span class="navbar-toggler-icon"></span>
                                        </button>
                                      
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                          <ul class="navbar-nav mr-auto">
                                            <li class="nav-item {{ Route::is('home') ? 'active current-page': '' }}">
                                              <a class="nav-link" href="{{route('home')}}">Home</a>
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
                                            <li class="nav-item register {{ Route::is('login') ? 'active': '' }}">
                                              <a class="nav-link" href="{{route('login')}}">Account</a>
                                            </li>
                                          </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
        <script src="{{ mix('js/calendar.js') }}" ></script>
        <script src="{{ asset('js/main.js') }}" ></script>
        <script src="{{ asset('js/helper.js') }}" ></script>
        {{isset($scripts) ? $scripts : ''}}
    </body>
</html>
