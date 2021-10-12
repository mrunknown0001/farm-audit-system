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
      @include('includes.common.common-sidebar')
    </ul>
  </section>
</aside>