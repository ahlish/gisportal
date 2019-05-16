@extends('layouts.default')

@section('content')

<div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Member Data</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row"> 
          <div class="col-sm-2" style="text-align: right;">
            <button class="btn btn-primary btn-sm" type="button"><a href="/master_member/create" style="text-decoration: none; color: white;">New Member</a></button>
          </div>
        </div>
        <br/>
        
      </div>
    </div>
  </div>

</div>
@stop