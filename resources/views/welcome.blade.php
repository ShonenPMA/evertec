<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="flex min-h-screen items-center justify-center">
        <h1 class="text-4xl">{{ config('app.name') }}</h1>
    </body>
</html>
