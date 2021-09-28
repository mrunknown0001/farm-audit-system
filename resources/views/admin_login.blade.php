<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - GeoLocator</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet"  href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <style>
      .login-logo > p {
        color: #373b3b !important;
      }
      body {
        background-color: #d2d6de !important;
      }

    </style>
  </head>
  <body class="hold-transition">
    <div class="wrapper">
      <div class="login-box">
        <div class="login-logo">
          <img  class="img" height="60px" src="{{ asset('img/bgc_logo.png') }}" alt="BGC">
          <p><b>GeoLocator</b></p>
        </div>
        <div class="login-box-body">
          @include('includes.success')
          @include('includes.error')
          <p class="login-box-msg">Administrator Login</p>
          <form action="{{ route('post.admin.login') }}" method="POST" autocomplete="off">
            @csrf
            <div id="email-group" class="form-group has-feedback">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email" required autofocus>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div id="password-group" class="form-group has-feedback">
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">
              </div>
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script> --}}
  </body>
</html>