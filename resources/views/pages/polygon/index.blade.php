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

    .editArea-container {
      background: #fff;
      font-family: "Avenir Next W00", "Helvetica Neue", Helvetica, Arial, sans-serif;
      line-height: 1.5em;
      overflow: auto;
      padding: 12px 15px;
      width: 300px;
      max-height: 500px;
      position: absolute;
      z-index: 10;
      text-align: right;
      right: 0;
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
  </style>

@section('content')

<div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Polygon</h2>
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

            <div id="editArea" class="editArea-container" style="width: 400px; max-height: 500px; display:none;">
              <div id="addFeatureDiv" style="display:block;">
                <div id="addTemplatesDiv" style="background:#fff;"></div>
              </div>

              <div id="featureUpdateDiv" style="display:none; margin-top: 1em;">
                <h3 class="list-heading">Enter information</h3>
                <div id="attributeArea">
                  <div id="formDiv"></div>
                  <input type="button" class="esri-button" value="Update Report"
                    id="btnUpdate">
                </div>
                <br />
                <div id="deleteArea">
                  <input type="button" class="esri-button" value="Delete Report" id="btnDelete">
                </div>
              </div>

              <div id="updateInstructionDiv" style="text-align:center; display:block">
              </div>
            </div>

            <div id="viewDiv">
              <div id="line-button" class="esri-widget esri-widget--button esri-interactive"
                title="Draw polygon">
                <span class="esri-icon-polygon"></span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@stop