<div class="left_col scroll-view">
  <div class="navbar nav_title" style="border: 0;">
    <p class="site_title"><span style="font-size: 17px;">GIS Portal</span></p>
  </div>

  <div class="clearfix"></div>
    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="{{ url('/images/img_male.png') }}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        @if(Auth::check())
          <span>Welcome, Administrator GIS Portal</span>
        @else
          <span>Welcome, Guest</span>
        @endif
        <h2></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Main Menu</h3>
        <ul class="nav side-menu">
          @if(Auth::check())
            <li class="{{isset($route) ? (($route == 'point' || $route == 'line' || $route == 'polygon') ? 'current-page' : '') : ''}}">
              <a><i class="fa fa-database"></i> Test Arcgis <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li class="{{isset($route) ? (($route == 'point') ? 'current-page' : '') : ''}}"><a href="{{ URL::to('point') }}">Point</a></li>
                <li class="{{isset($route) ? (($route == 'line') ? 'current-page' : '') : ''}}"><a href="{{ URL::to('line') }}">Line</a></li>
                <li class="{{isset($route) ? (($route == 'polygon') ? 'current-page' : '') : ''}}"><a href="{{ URL::to('polygon') }}">Polygon</a></li>
              </ul>
            </li>
            <li class="{{isset($route) ? (($route == 'kebocoran_pipa') ? 'current-page' : '') : ''}}"><a href="/kebocoran_pipa"><i class="fa fa-user"></i>Kebocoran Pipa</a></li>
            <li class="{{isset($route) ? (($route == 'pasang_baru') ? 'current-page' : '') : ''}}"><a href="/pasang_baru"><i class="fa fa-newspaper-o"></i>Pasang Baru</a></li>
          @else
            <li class="{{isset($route) ? (($route == 'pengaduan_v2') ? 'current-page' : '') : ''}}"><a href="{{ url('/pengaduan_v2/create') }}"><i class="fa fa-user"></i>Pengaduan</a></li>
            <li class="{{isset($route) ? (($route == 'monitoring_cater') ? 'current-page' : '') : ''}}"><a href="{{ url('/monitoring_cater') }}"><i class="fa fa-user"></i>Monitoring Catat Meter</a></li>
            <li class="{{isset($route) ? (($route == 'monitoring_pengaduan') ? 'current-page' : '') : ''}}"><a href="{{ url('/monitoring_pengaduan') }}"><i class="fa fa-user"></i>Monitoring Pengaduan</a></li>
          @endif
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>