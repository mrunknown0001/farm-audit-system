<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') {{ $system->system_title_suffix }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet"  href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
    @if(Auth::User()->role_id == 2 || Auth::User()->role_id == 1)
    <link rel="stylesheet" href="{{ asset('adminlte/css/skins/' . $system->admin_skin . '.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('adminlte/css/skins/' . $system->user_skin . '.min.css') }}">
    @endif
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    @yield('style')
  </head>
  <body class="hold-transition {{ Auth::user()->role_id == 2 ? $system->admin_skin : $system->user_skin }} sidebar-mini">
  <div class="wrapper">
    @if(Auth::User()->role_id == 2 || Auth::User()->role_id == 1)
      @include('admin.includes.header')
    @else
      @include('includes.common.header')
    @endif
    @yield('sidebar')
    @yield('content')
    @include('includes.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}" defer="defer"></script>
    <script src="{{ asset('js/sweetalert.js') }}" defer="defer"></script>

    @yield('script')
    @include('includes.timeout')
    @if(Auth::check())
      @if(\App\Http\Controllers\AccessController::checkAccess(Auth::user()->id, 'audit_reviewer'))
        @include('includes.notification')
      @endif
      @if(\App\Http\Controllers\AccessController::checkAccess(Auth::user()->id, 'reports'))
        @include('includes.chart-scripts')
      @endif
    @endif
  </body>
</html>