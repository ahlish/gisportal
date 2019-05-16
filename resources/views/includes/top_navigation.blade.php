<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="{{ url('/images/img.png') }}" alt="">Administrator GIS Portal
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a href="javascript:;"> Profile</a></li>
              <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out pull-right"></i> Log Out
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
              </li>
            </ul>
          </li>
        @else
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="{{ url('/images/img.png') }}" alt="">Guest
              <span class=" fa fa-angle-down"></span>
            </a>
          </li>
        @endif
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->