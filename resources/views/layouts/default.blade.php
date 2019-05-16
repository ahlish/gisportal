<!DOCTYPE html>
<html lang="en">
  <head>

    @include('includes.head')

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          
          @include('includes.left_menu')

          @include('includes.top_navigation')

          <!-- page content -->
          <div class="right_col" role="main">
            @yield('content')
          </div>
          <!-- /page content -->

          @include('includes.footer')          
      </div>
    </div>

    @include('includes.footer_js')

  </body>
</html>
