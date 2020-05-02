<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('SITE_TITLE', 'Almanac') }}</title>

        <!-- Styles -->
        <link href="{{ asset('dist/app.css') }}" rel="stylesheet">

        <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="{{ asset('apple-touch-icon.png') }}">

        <script src="https://kit.fontawesome.com/4faa09972b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        @yield('content')
        <script src="{{ asset('dist/bundle.js') }}"></script>
    </body>
</html>
