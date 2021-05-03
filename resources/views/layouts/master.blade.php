<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @stack('meta')
        <title>@yield('prefix') -  @yield('title')</title>
        <link rel="icon" href="{{ asset('/images/icon.png') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
        @stack('head')
    </head>
    <body>
        <div id="app" class="w-full">
            @yield('app')
        </div>
        @stack('modals')
        @stack('scripts')
    </body>
</html>
