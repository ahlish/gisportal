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

  </style>

@section('content')

<div> 
  <div class="row">

    <div class="col-md-6 col-sm-12 col-xs-12">
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
            <form enctype="multipart/form-data" method="post" action="/master_news/save" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No. Pengaduan </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="" value="{{ isset($master_news) ? $master_news->title : null }}" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tanggal Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" title" value="{{ isset($master_news) ? $master_news->title : date('d-m-Y') }}" required disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asal Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control col-md-7 col-xs-12" name="asal_pengaduan">
                    @foreach($asal_pengaduan as $data)
                      <option value="{{ $data->asal_pengaduan }}">{{ $data->keterangan }}</option>
                    @endforeach
                  </select> 
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Pelapor<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g John Legend" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat Pelapor<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g Jalan Dharmahusada 12 Surabaya" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telepon Pelapor<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g 08123456789" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g News title" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g type address here" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Uraian
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g Description your report here" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Zona<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g Description your report here" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <button class="btn btn-primary" type="reset"><a href="/master_news" style="text-decoration: none; color: white;">Back</a></button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xs-12">
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
            <div class="col-sm-12" style="text-align: right;">
               <div id="editArea" class="editArea-container" style="width: 400px; max-height: 500px; display: none;">
                <div id="addFeatureDiv" style="display:block;">
                  <h3 class="list-heading">Pipe Leakage Report</h3>
                  <ul style="font-size: 13px; padding-left: 1.5em;">
                    <li>Select template from the list</li>
                    <li>Click on the map to create a new feature</li>
                    <li>Update associated attribute data</li>
                    <li>Click <i>Update Report Information</i></li>
                  </ul>
                  <div id="addTemplatesDiv" style="background:#fff;"></div>
                </div>

                <div id="featureUpdateDiv" style="display:none; margin-top: 1em;">
                  <h3 class="list-heading">Enter the report information</h3>
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
                  <p class="or-wrap">
                    <span class="or-text">Or</span>
                  </p>
                  <p id="selectHeader">Select an report point to edit or delete.</p>
                </div>
              </div>
              <div id="viewDiv"></div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
@stop