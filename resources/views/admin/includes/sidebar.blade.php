<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header text-center">
        Admin Menu
      </li>
      <li class="{{ route('admin.dashboard') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('admin.dashboard') }}">
          <i class="fa fa-chart-line"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="treeview {{ route('admin.users') == url()->current() ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i class="fa fa-users"></i> <span>Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu {{ route('admin.users') == url()->current() ? 'active' : '' }}">
          <li><a href="{{ route('admin.users') }}"><i class="fa fa-arrow-circle-right"></i> All</a></li>
        </ul>
      </li>
      <li class="{{ route('system.config') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('system.config') }}">
          <i class="fa fa-cog"></i> <span>System Config</span>
        </a>
      </li>
      <li class="{{ route('access') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('access') }}">
          <i class="fa fa-universal-access"></i> <span>User Access</span>
        </a>
      </li>
      <li class="{{ route('database.backup') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('database.backup') }}">
          <i class="fa fa-database"></i> <span>Database</span>
        </a>
      </li>
      <li class="{{ route('user.logs') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('user.logs') }}">
          <i class="fa fa-history"></i> <span>User Logs</span>
        </a>
      </li>
      <li class="{{ route('admin.farms') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('admin.farms') }}">
          <i class="fa fa-tractor"></i> <span>Farms</span>
        </a>
      </li>
      @include('includes.common.common-sidebar')
    </ul>
  </section>
</aside>