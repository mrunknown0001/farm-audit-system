<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header text-center">
        Menu
      </li>
      <li class="{{ route('user.dashboard') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('user.dashboard') }}">
          <i class="fa fa-chart-line"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="{{ route('user.employees') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('user.employees') }}">
          <i class="fa fa-users"></i> <span>Employees</span>
        </a>
      </li>
      <li class="{{ route('user.punches') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('user.punches') }}">
          <i class="fa fa-map-marker"></i> <span>Punches</span>
        </a>
      </li>
    </ul>
  </section>
</aside>