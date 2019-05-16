<!-- jQuery -->
<script src="{{ url('/vendors/jquery/dist/jquery.min.js') }} "></script>
<!-- Bootstrap -->
<script src="{{ url('/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('/vendors/fastclick/lib/fastclick.js') }} "></script>
<!-- NProgress -->
<script src="{{ url('/vendors/nprogress/nprogress.js') }} "></script>
<!-- Chart.js -->
<script src="{{ url('/vendors/Chart.js/dist/Chart.min.js') }} "></script>
<!-- gauge.js -->
<script src="{{ url('/vendors/gauge.js/dist/gauge.min.js') }} "></script>
<!-- bootstrap-progressbar -->
<script src="{{ url('/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }} "></script>
<!-- iCheck -->
<script src="{{ url('/vendors/iCheck/icheck.min.js') }} "></script>
<!-- Skycons -->
<script src="{{ url('/vendors/skycons/skycons.js') }} "></script>
<!-- Flot -->
<script src="{{ url('/vendors/Flot/jquery.flot.js') }} "></script>
<script src="{{ url('/vendors/Flot/jquery.flot.pie.js') }} "></script>
<script src="{{ url('/vendors/Flot/jquery.flot.time.js') }} "></script>
<script src="{{ url('/vendors/Flot/jquery.flot.stack.js') }} "></script>
<script src="{{ url('/vendors/Flot/jquery.flot.resize.js') }} "></script>
<!-- Flot plugins -->
<script src="{{ url('/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }} "></script>
<script src="{{ url('/vendors/flot-spline/js/jquery.flot.spline.min.js') }} "></script>
<script src="{{ url('/vendors/flot.curvedlines/curvedLines.js') }} "></script>
<!-- DateJS -->
<script src="{{ url('/vendors/DateJS/build/date.js') }} "></script>
<!-- JQVMap -->
<script src="{{ url('/vendors/jqvmap/dist/jquery.vmap.js') }} "></script>
<script src="{{ url('/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }} "></script>
<script src="{{ url('/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }} "></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ url('/vendors/moment/min/moment.min.js') }} "></script>
<script src="{{ url('/vendors/bootstrap-daterangepicker/daterangepicker.js') }} "></script>

<!-- Datatables -->
<script src="{{ url('/vendors/datatables.net/js/jquery.dataTables.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-buttons/js/buttons.flash.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-buttons/js/buttons.html5.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-buttons/js/buttons.print.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }} "></script>
<script src="{{ url('/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }} "></script>
<script src="{{ url('/vendors/jszip/dist/jszip.min.js') }} "></script>
<script src="{{ url('/vendors/pdfmake/build/pdfmake.min.js') }} "></script>
<script src="{{ url('/vendors/pdfmake/build/vfs_fonts.js') }} "></script>

<!-- validator -->
<script src="{{ url('/vendors/validator/validator.js') }} "></script>

<!-- Custom Theme Scripts -->
<script src="{{ url('/build/js/custom.min.js') }} "></script>

<!-- jQuery autocomplete -->
<script src="{{ url('/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }} "></script>

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Javascript libary of Arcgis Javascript -->
<script src="https://js.arcgis.com/4.11/"></script>

@if (isset($route))

  @if($route == 'pengaduan')
    <script src="{{ url('/js/arcgis/pengaduan.js') }} "></script>
  @endif

  @if($route == 'pengaduan_v2')
    <script src="{{ url('/js/arcgis/pengaduan.js') }} "></script>
  @endif

  @if($route == 'kebocoran_pipa')
    <script src="{{ url('/js/arcgis/kebocoran_pipa.js') }} "></script>
  @endif

  @if($route == 'pasang_baru')
    <script src="{{ url('/js/arcgis/pasang_baru.js') }} "></script>
  @endif

  @if($route == 'point')
    <script src="{{ url('/js/arcgis/point.js') }} "></script>
  @endif

  @if($route == 'line')
    <script src="{{ url('/js/arcgis/line.js') }} "></script>
  @endif

  @if($route == 'polygon')
    <script src="{{ url('/js/arcgis/polygon.js') }} "></script>
  @endif

  @if($route == 'monitoring_pengaduan')
    <script src="{{ url('/js/arcgis/monitoring_pengaduan.js') }} "></script>
  @endif

  @if($route == 'monitoring_cater')
    <script src="{{ url('/js/arcgis/monitoring_cater.js') }} "></script>
  @endif
@endif

<script type="text/javascript">
  $('.member-search').select2({
    placeholder: 'Type customer name',
    ajax: {
      url: "https://web-develop.pdam-sby.go.id/gisportal/ajax_pelanggan",
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            var name = item.nama + " - " + item.no_plg;
            return {
              text: name,
              id: item.no_plg
            }
          })
        };
      },
      cache: true
    }
  });

  function onchangeCustomer() {
    // alert("aa");
    // console.log(document.getElementById('nama_pelanggan').value);
    var id = document.getElementById('nama_pelanggan').value;

    if (id) {
      $.ajax({
        url: "https://web-develop.pdam-sby.go.id/gisportal/service/pelanggan_detail/" + id,
        type: "GET",
        success: function(result) {
          // console.log(result);
          // console.log(result.jalan);
          if (result.jalan) {
            document.getElementById("pelanggan_jalan").value = "Jalan : " + result.jalan;
          }

          if (result.gang) {
            document.getElementById("pelanggan_gang").value = "Gang : " + result.gang;
          }

          if (result.nomor) {
            document.getElementById("pelanggan_no").value = "No : " + result.nomor;
          }

          if (result.notamb) {
            document.getElementById("pelanggan_no_tambahan").value = "No. Tambahan : " + result.notamb;
          }

          if (result.da) {
            document.getElementById("pelanggan_da").value = "DA : " + result.da;
          }

          if (result.no_plg) {
            document.getElementById("no_plg").value = result.no_plg;
          }

        },
        error: function(err) {
          console.log(err);
        }
      });
    }
  }
</script>