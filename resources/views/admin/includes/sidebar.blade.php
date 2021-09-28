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
          {{-- <li><a href=""><i class="fa fa-arrow-circle-right"></i> Others</a></li> --}}
        </ul>
      </li>

      <li class="{{ route('schedule') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('schedule') }}">
          <i class="fa fa-calendar"></i> <span>Schedule</span>
        </a>
      </li>
      <li class="{{ route('admin.punches') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('admin.punches') }}">
          <i class="fa fa-map-marker"></i> <span>Punches</span>
        </a>
      </li>
    </ul>
  </section>
</aside>