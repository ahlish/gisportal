@extends('layouts.default')
  <style>
    html,
    body,
    #viewDiv {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
    }
  </style>

@section('content')

<div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Pasang Baru</h2>
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
          <div class="col-sm-12" style="text-align: right;">
            
            <div id="viewDiv">
              <div id="line-button" class="esri-widget esri-widget--button esri-interactive"
                title="Draw polyline">
                <span class="esri-icon-polyline"></span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@stop