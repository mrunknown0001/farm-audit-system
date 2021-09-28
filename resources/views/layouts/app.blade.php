<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | GeoLocator</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet"  href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    @yield('style')
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    @yield('header')
    @yield('sidebar')
    @yield('content')
    @include('includes.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    @yield('script')
    @include('includes.timeout')
  </body>
</html>