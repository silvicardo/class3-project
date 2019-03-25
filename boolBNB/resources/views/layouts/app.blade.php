<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BoolB&B') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel='stylesheet' type='text/css' href="{{ asset('sdk/map.css')}}">
    <script src="{{ asset('sdk/tomtom.min.js') }}"></script>
</head>
<body>
    <div id="app">
        @include('partials._header')

        <main class="py-4">
            @yield('user_feedback')
            @yield('alerts')
            @yield('content')
        </main>

        @include('partials._footer')
    </div>
    @yield('scripts')
</body>
</html>
