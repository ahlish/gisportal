var lat = null;
var long = null;
navigator.geolocation.getCurrentPosition(function (res) {
  lat = res.coords.latitude;
  long = res.coords.longitude;
  document.getElementById('latitude').value = lat;
  document.getElementById('longitude').value = long;
  document.getElementById('y_axis').value = lat;
  document.getElementById('x_axis').value = long;
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
"dijit/form/Button",
"dojo/dom",
"dojo/domReady!",
"dojo/request"
],
function(
Map, MapView, FeatureLayer, Graphic, Expand,
FeatureForm, FeatureTemplates, Search, SimpleMarkerSymbol, SimpleLineSymbol, Color, Point, Button, dom, Request
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
    zoom: 13
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

  var attributes = {
    Longitude : long,
    Latitude: lat
  }

  var popupTemplate = {
    title: "Address",
    content: "Longitude : <b>{Longitude}</b>, Latitude : <b>{Latitude}</b>"
  };

  var pictureGraphic = new Graphic({
   geometry: {
     type: "point",
    x: long,
    y: lat,
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

 view.graphics.add(pictureGraphic);

 // SET ADDRESS TO FORM BASED ON LATITUDE AND LONGITUDE OF USER
 setAddress(long, lat);

 // ENVENT HANDLING OF USER CLICK ON THE Map
  view.on('click', function(e){
    var coordinates = [e.x, e.y, e.mapPoint.latitude, e.mapPoint.longitude];

    createPointGraphic(coordinates);
  });

  function createPointGraphic(coordinates){
    view.graphics.removeAll();

    var attributes = {
      Longitude : coordinates[3],
      Latitude: coordinates[2]
    }
    var popupTemplate = {
      title: "Address",
      content: "Longitude : <b>{Longitude}</b>, Latitude : <b>{Latitude}</b>"
    };
    var pictureGraphic = new Graphic({
      geometry: {
        type: "point",
        x: coordinates[3],
        y: coordinates[2],
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

    editFeature = new Graphic({
      geometry: {
        type: "point",
        x: coordinates[3],
        y: coordinates[2]
      },
      attributes: {
        "nopengaduan": "1233"
      }
    });

    view.graphics.add(pictureGraphic);
    document.getElementById("latitude").value = coordinates[2];
    document.getElementById("longitude").value = coordinates[3];
    document.getElementById("y_axis").value = coordinates[2];
    document.getElementById("x_axis").value = coordinates[3];
    setAddress(coordinates[3], coordinates[2])
  }

  function setAddress(long, lat) {
    var Url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=json&featureTypes=&location=" + long + "," + lat;
    $.ajax({
      url: Url,
      type: "GET",
      success: function(result) {
        document.getElementById("alamat_pengaduan").value = result.address.LongLabel;
      },
      error: function(err) {
        console.log(err);
      }
    });
  }

});