@extends('layouts.default')
<style>
    html,
    body,
    #viewDiv {
      padding: 0;
      margin: 0;
      height: 100%;
      width: 100%;
    }
    #messages{
      background-color: #fff;
      box-shadow: 0 0 5px #888;
      font-size: 1.1em;
      max-width: 15em;
      padding: 0.5em;
      position: absolute;
      right: 20px;
      top: 20px;
      z-index: 40;
      }

    .editArea-container {
      background: #fff;
      font-family: "Avenir Next W00", "Helvetica Neue", Helvetica, Arial, sans-serif;
      line-height: 1.5em;
      overflow: auto;
      padding: 12px 15px;
      width: 300px;
    }

    .list-heading {
      font-weight: normal;
      margin-top: 20px;
      margin-bottom: 10px;
      color: #323232;
    }

    .or-wrap {
      background-color: #e0e0e0;
      height: 1px;
      margin: 2em 0;
      overflow: visible;
    }

    .or-text {
      background: #fff;
      line-height: 0;
      padding: 0 1em;
      position: relative;
      bottom: 0.75em;
    }

    /* override default styles */
    .esri-feature-form {
      background: #fff;
    }

    .esri-feature-templates {
      width: 280px;
    }

    .esri-feature-templates__section-header {
      display: none;
    }

    .esri-feature-templates__section {
      box-shadow: none;
    }

    .esri-feature-templates__list {
      max-height: 180px;
    }

    input:read-only {
      background-color: gray;
    }

  </style>

@section('content')

<div>
  <div class="row">
    <div class="col-sm-12">
      @if (session('status'))
          <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <span>{{ session('status') }}</span>
          </div>

      @endif

      @if (session('warning'))

          <div class="alert alert-warning alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <span>{{ session('warning') }}</span>
          </div>

      @endif
    </div>
    <input type="hidden" id="latitude" name="latitude" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g type address here" />
    <input type="hidden" id="longitude" name="longitude" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g type address here" />

<!--     <div class="col-md-6 col-sm-12 col-xs-12">
       <div class="x_panel">
          <div class="x_title">
            <h2>Data Pengaduan</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

          </div>
        </div>
    </div> -->

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>MAP</h2>
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
              <div id="viewDiv"></div>
              <div id="button">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
@stop