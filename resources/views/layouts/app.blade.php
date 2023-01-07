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
                </div>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}" ></script>
        <script src="{{ mix('js/theme.js') }}" ></script>
        <script src="{{ asset('js/helper.js') }}" ></script>
        <script src="{{ asset('js/main.js') }}" ></script>
        {{ isset($scripts) ? $scripts : ''}}
    </body>
</html>
