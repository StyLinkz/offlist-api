<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/js/lib/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/js/lib/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/color.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('vendors/css/custom.css') }}"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <!-- Scripts -->
    {{-- <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/css/color.css"> --}}
    <link rel="icon" href="favicon.png" type="image/png" />
</head>

<body>
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEu81nqJqarzuaHRQJGXS3cBqRPtB8OUI&libraries=places"></script>

    <div id="app">
        <v-app>
            @yield('content')
        </v-app>
    </div>

    <script src="{{ asset('vendors/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('vendors/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('vendors/js/bootstrap.min.js') }}"></script>
    {{-- <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> --}}
    {{-- <script src="{{ asset('vendors/js/lib/slick/slick.js') }}"></script> --}}
    <script src="{{ asset('vendors/js/scripts.js') }}"></script>

    <script src="{{ asset('vendors/js/map-cluster/infobox.min.js') }}"></script>
    <script src="{{ asset('vendors/js/map-cluster/infobox.min.js') }}"></script>
    <script src="{{ asset('vendors/js/map-cluster/markerclusterer.js') }}"></script>
    <script src="{{ asset('vendors/js/map-cluster/maps.js') }}"></script>

</body>

</html>
