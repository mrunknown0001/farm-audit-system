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
    </ul>
  </section>
</aside>