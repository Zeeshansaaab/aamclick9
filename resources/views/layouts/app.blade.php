<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    </head>
    <body class="nk-body npc-crypto bg-white has-sidebar ">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                @include('layouts.navigation')
                <div class="nk-wrap ">
                    @include('layouts.header')
                    <div class="nk-content nk-content-fluid">
                        <div class="container-xl wide-lg">
                            <div class="nk-content-body">     
                                <div class="nk-block-head">
                                    {{ $breadcrumb }}
                                    {{ $header }}
                                </div>
                                <div class="nk-block">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-footer-fluid">
                        <div class="container-fluid">
                            <div class="nk-footer-wrap">
                                <div class="nk-footer-copyright"> © 2023 AAM Express. All Rights Reserved <a href="https://aamexpress.com">AAMEXPRESS</a>
                                </div>
                                <div class="nk-footer-links">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="nav-link" href="https://aamclick.com/policy/privacy-and-policy/72">Terms</a></li>
                                        <li class="nav-item"><a class="nav-link" href="https://aamclick.com/policy/payment-policy/73">Privacy</a></li>
                                        {{-- <li class="nav-item"><a class="nav-link" href="#">Help</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}" ></script>
        <script src="{{ mix('js/theme.js') }}" ></script>
        <script src="{{ asset('js/helper.js') }}" ></script>
        <script src="{{ asset('js/main.js') }}" ></script>
        {{ isset($scripts) ? $scripts : ''}}
        
        <script>
            var limit = 5;
            $(document).on('click', '.notification-dropdown-trigger, .view-all, .markAllasread', function(){
                let count = parseInt("{{auth()->user()->unreadNotifications->count()}}");
                var is_all = false;

                if($(this).hasClass('markAllasread')){
                    is_all = true;
                }

                if(count > limit){
                    $('.load-more').removeClass('d-none');
                    limit = (limit + 4) >= count ? count : limit + 4;
                }
                ajax('/notifications', 'GET', function(response){
                    $('#notification-dropdown-items').html(response)
                    $('#notifications-list').toggle()
                    if(limit >= count || is_all){
                        $('.view-all').addClass('d-none')
                        limit = 0
                    }
                }, {limit: limit, is_all: is_all})
            })
        </script>
    </body>
</html>
