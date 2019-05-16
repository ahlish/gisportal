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
            <form method="post" action="{{ url('/pengaduan/save') }}" class="form-horizontal form-label-left">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No. Pengaduan </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="no_pengaduan" name="no_pengaduan" required="required" class="form-control col-md-7 col-xs-12" placeholder="" value="{{ isset($pengaduan) ? $pengaduan->NO_PENGADUAN : null }}" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tanggal Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="tanggal_pengaduan" name="tanggal_pengaduan" required="required" class="form-control col-md-7 col-xs-12" title" value="{{ isset($master_news) ? $master_news->title : date('d-m-Y') }}" required disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asal Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control col-md-7 col-xs-12" name="asal_pengaduan" id="asal_pengaduan" required>
                    <option value="">Choose Asal Pengaduan</option>
                    @foreach($asal_pengaduan as $data)
                      <option value="{{ $data->asal_pengaduan }}">{{ $data->keterangan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control col-md-7 col-xs-12" name="jenis_pengaduan" id="jenis_pengaduan" required>
                    <option value="">Choose Jenis Pengaduan</option>
                    @foreach($jenis_pengaduan as $data)
                      <option value="{{ $data->jns_pengaduan }}">{{ $data->keterangan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Pelapor<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="nama_pelapor" name="nama_pelapor" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g John Legend" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat Pelapor<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="alamat_pelapor" name="alamat_pelapor" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g Jalan Dharmahusada 12 Surabaya" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telepon Pelapor<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="telepon_pelapor" name="telepon_pelapor" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g 08123456789" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat Pengaduan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="alamat_pengaduan" name="alamat_pengaduan" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g type address here" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
               <div class="form-group" style="display: none;">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Latitude<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="latitude" name="latitude" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g type address here" value="{{ isset($master_news) ? $master_news->title : null }}" required readonly>
                </div>
              </div>
               <div class="form-group" style="display: none;">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Longitude<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="longitude" name="longitude" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g type address here" value="{{ isset($master_news) ? $master_news->title : null }}" required readonly >
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Uraian
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="uraian" name="uraian" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g Description your report here" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Zona<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="zona" name="zona" required="required" class="form-control col-md-7 col-xs-12" placeholder="e.g Zona" value="{{ isset($master_news) ? $master_news->title : null }}" required autofocus>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-success">Submit</button>
                  <button class="btn btn-primary" type="reset"><a href="/" style="text-decoration: none; color: white;">Back</a></button>
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
              <div id="viewDiv"></div>
              <div id="button">
                  <button id='buffer' type="button"></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
@stop