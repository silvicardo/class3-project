<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
      $nomePaginaCorrente = Route::current()->getName();
    @endphp
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BoolB&B') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    @if ($nomePaginaCorrente === 'search')
        <link rel='stylesheet' type='text/css' href="{{ asset('sdk/map.css')}}"/>
    @endif
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel='stylesheet' type='text/css' href="{{ asset('sdk/map.css')}}">

    @if ($nomePaginaCorrente === 'search'
          || $nomePaginaCorrente === 'apartment.create'
          || $nomePaginaCorrente === 'apartment.edit'
          || $nomePaginaCorrente === 'apartment.show' )
      <script type='text/javascript' src={{ asset('sdk/form.js')}}></script>
      <script src="{{ asset('sdk/tomtom.min.js') }}"></script>
  @endif
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
