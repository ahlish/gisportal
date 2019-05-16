var lat = null;
var long = null;
navigator.geolocation.getCurrentPosition(function (res) {
  lat = res.coords.latitude;
  long = res.coords.longitude;
  document.getElementById('latitude').value = lat;
  document.getElementById('longitude').value = long;
});

require([
"esri/Map",
"esri/views/MapView",
"esri/layers/FeatureLayer",
"esri/Graphic",
"esri/widgets/Expand",
"esri/widgets/FeatureForm",
"esri/widgets/FeatureTemplates",
"esri/widgets/Search",
"dojo/_base/Color",
"esri/symbols/SimpleLineSymbol",
"esri/symbols/SimpleMarkerSymbol",
"esri/geometry/Point",
"esri/geometry/support/webMercatorUtils",
"dijit/form/Button",
"dojo/dom",
"dojo/domReady!",
"dojo/request",
"dojo/parser",
"esri/geometry/support/webMercatorUtils",
"dojo/on",
"dojo/mouse"
],
function(
Map, MapView, FeatureLayer, Graphic, Expand,
FeatureForm, FeatureTemplates, Search, SimpleMarkerSymbol, SimpleLineSymbol, Color, Point, button, on, dom, mouse, Request, webMercatorUtils
) {

  let editFeature, highlight, view;

  const map = new Map({
    basemap: "topo",
    layers: [],
  });

  view = new MapView({
    container: "viewDiv",
    map: map,
    center: [long, lat],
    zoom: 11
  });

  var searchWidget = new Search({
    view: view,
    locationEnabled: false,
    resultGraphicEnabled: false
  });

  view.ui.add(searchWidget, {
    position: "top-right",
    index: 2
  });

  var myButton = dom.byId("submit_filter");

  document.getElementById('submit_filter').onclick = function () {
    var e = document.getElementById("start_period");
    var start_period = e.options[e.selectedIndex].value;

    var f = document.getElementById("end_period");
    var end_period = f.options[f.selectedIndex].value;

    console.log(start_period + " " + end_period);
    getAllPoint(start_period, end_period);
  };

 // FIRST GEL ALL POINT
 getAllPoint();



  function getAllPoint(start_period=null, end_period=null) {
    var Url = "https://web-develop.pdam-sby.go.id/gisportal/service/get_cater";
    $.ajax({
      url: Url,
      type: "POST",
      data: {
           "start_period" : start_period,
           "end_period" : end_period
      },
      success: function(result) {
        console.log(result);
        view.graphics.removeAll();
        if (result.payload.length > 0) {
          result.payload.map(function(data){
            var attributes = {
              Longitude : data.pos_long,
              Latitude: data.pos_lat
            }
            var popupTemplate = {
              title: "Catat Meter Detail",
              content: "Nolang : " + data.nolang
            };

            var pictureGraphic2 = new Graphic({
             geometry: {
               type: "point",
              x: data.pos_long,
              y: data.pos_lat,
             },
             symbol: {
               type: "picture-marker",
               url: "https://developers.arcgis.com/labs/images/bluepin.png",
               width: "14px",
               height: "26px"
             },
             attributes: attributes,
             popupTemplate: popupTemplate
           });

           view.graphics.add(pictureGraphic2);
          });
        }

      },
      error: function(err) {
        console.log(err);
      }
    });
  }

});