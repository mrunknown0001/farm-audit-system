    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) 
      <li class="{{ route('locations') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('locations') }}">
          <i class="fa fa-location-arrow"></i> <span>Locations</span>
        </a>
      </li>
    @endif
    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) 
      <li class="{{ route('sub.locations') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('sub.locations') }}">
          <i class="fa fa-location-arrow"></i> <span>Sub Locations</span>
        </a>
      </li>
    @endif
    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) 
      <li class="{{ route('assignments') == url()->current() ? 'active' : '' }}">
        <a href="{{ route('assignments') }}">
          <i class="fa fa-people-carry"></i> <span>Assignments</span>
        </a>
      </li>
    @endif
      {{-- <li class="treeview ">
        <a href="javascript:void(0)">
          <i class="fa fa-users"></i> <span>Main Menu</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu "> 
          <li><a href=""><i class="fa fa-arrow-circle-right"></i> Sub Menu</a></li>
        </ul>
      </li> --}}