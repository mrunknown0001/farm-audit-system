  <header class="main-header">
    <a href="javascript:void(0)" class="logo">
      <span class="logo-mini"><b>{{ $system->system_short_name }}</b></span>
      <span class="logo-lg"><b>Admin</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="javascript:void(0)" class="header-menu-custom" data-toggle="push-menu" role="button">
        <i class="fas fa-bars"></i>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/avatar.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->first_name }} <i class="fa fa-caret-down"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ asset('img/avatar.jpg') }}" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->first_name }}
                  <small>Admin</small>
                </p>
              </li>
              <li class="user-body">
                <div class="row">
                  <div class="col-md-12">
                    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-sm btn-block"><i class="fa fa-user"></i> Profile</a>
                  </div>
                  <div class="col-md-12"></div>
                  <div class="col-md-12">
                    <a href="{{ route('admin.change.password') }}" class="btn btn-default btn-sm btn-block"><i class="fa fa-key"></i> Change Password</a>
                  </div>
                </div>
              </li>
              <li class="user-footer">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat btn-sm btn-block"><i class="fa fa-sign-out"></i> Logout</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>