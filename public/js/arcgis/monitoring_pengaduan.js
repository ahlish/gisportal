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
"esri/geometry/support/webMercatorUtils"
],
function(
Map, MapView, FeatureLayer, Graphic, Expand,
FeatureForm, FeatureTemplates, Search, SimpleMarkerSymbol, SimpleLineSymbol, Color, Point, button, dom, Request, webMercatorUtils
) {

  // var normalizedVal = webMercatorUtils.lngLatToXY(Number(42215329), Number(1321748));
  // console.log(normalizedVal); //returns 19.226, 11.789

  let editFeature, highlight, view;

  const featureLayer = new FeatureLayer({
    url: "https://gis.pdam-sby.go.id/server/rest/services/trial_pengaduan/FeatureServer/0",
    outFields: ["*"],
    popupEnabled: false,
    id: "incidentsLayer"
  });

  const map = new Map({
    basemap: "topo",
    layers: [featureLayer],
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

  var pictureGraphic2 = new Graphic({
   geometry: {
     type: "point",
    x: 112.76443670536918,
    y: -7.270090213501723,
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
 view.graphics.add(pictureGraphic2);

 // var point = Point(693906.64670000039, 9196707.8028999995, { wkid: 102113 });
 // var mp = esri.geometry.geographicToWebMercator(point);
 // point = new esri.geometry.Point({ "x": mp.x, "y": mp.y, "spatialReference": { "wkid": 102113} });
 // var graphic = new esri.Graphic(point, defaultSymbol);
 // map.graphics.add(graphic);

 // var coordinates = [112.75435519999999, -7.2649356, 112.75435519999999, -7.2649356];
  // console.log("aaaa");
  // createPointGraphic(coordinates);
 console.log(long + " " + lat);
 // getAllPoint();
 setAddress(long, lat);

  view.on('click', function(e){
    // alert("clicked");
    var coordinates = [e.x, e.y, e.mapPoint.latitude, e.mapPoint.longitude];
    // var coordinates = [691405.1827999996, 9198861.9648, 691405.1827999996, 9198861.9648];

    createPointGraphic(coordinates);
  });

  function createPointGraphic(coordinates){
    // view.graphics.removeAll();

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
    // setAddress(coordinates[3], coordinates[2])
  }

  function setAddress(long, lat) {
    var Url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=json&featureTypes=&location=" + long + "," + lat;
    $.ajax({
      url: Url,
      type: "GET",
      success: function(result) {
        // document.getElementById("alamat_pengaduan").value = result.address.LongLabel;
      },
      error: function(err) {
        console.log(err);
      }
    });
  }

  function submitPengaduan() {
    alert('a');
    return null;
    const edits = {
      addFeatures: [editFeature]
    };

    applyEditsToIncidents(edits);
  }

  function getAllPoint() {
    var Url = "https://gis.pdam-sby.go.id/server/rest/services/trial_pengaduan/FeatureServer/0/query";
    $.ajax({
      url: Url,
      type: "POST",
      data: {
           "f" : "json",
           "token" : "yK0vsPLwtKyEe9f_oev23Ra0_lbY1PskKqHJhxEHOavv790kMRBdx8pi9-5SERRjQdcKv4KL48c5SBfWV8EdSxi1t63Mh9vn4D7Ri2hkQ0qHiD7UGYM6tDZfH7fS2VFGQd4JoTU6dFuOpRIv0fgMmECpg-pFVvhhpYHfGYSzE6nN5LcZNER1L-OBqWSNeXW3qkCSwpwCQ8i2Toc6fF5AOK3fo7mTOQcbUex__4Kg9AU.",
           "outFields" : "*",
           "where" : "nopengaduan like '%%'",
           "geometryType": "esriGeometryPoint"
      },
      success: function(result) {
        console.log(result);
        var features = result.features;
        if (features.length > 0) {
          features.map(function(data){
            // var coordinates = [data.geometry.x, data.geometry.y, data.geometry.x, data.geometry.y];
            var coordinates = [data.geometry.x, data.geometry.y, 112.75435519999999, -7.2649356];
            console.log("aaaa");
            createPointGraphic(coordinates);
          });
        }
        //document.getElementById("alamat_pengaduan").value = result.address.LongLabel;
      },
      error: function(err) {
        console.log(err);
      }
    });
  }

  // Sumbit button action
  var myButton = new Button({
      label: "Click me!",
      onClick: function(){
          // Do something:
          // dom.byId("result1").innerHTML += "Thank you! ";
          // alert('aaa');
          const edits = {
            addFeatures: [editFeature]
          };

          applyEditsToIncidents(edits);
      }
  }, "buffer").startup();

   // Call FeatureLayer.applyEdits() with specified params.
  function applyEditsToIncidents(params) {
    // unselectFeature();
    featureLayer.applyEdits(params).then(function(editsResult) {
      // Get the objectId of the newly added feature.
      // Call selectFeature function to highlight the new feature.
      if (editsResult.addFeatureResults.length > 0 || editsResult.updateFeatureResults.length > 0) {
        unselectFeature();
        let objectId;
        if (editsResult.addFeatureResults.length > 0) {
          objectId = editsResult.addFeatureResults[0].objectId;
        }
        else {
          featureForm.feature = null;
          objectId = editsResult.updateFeatureResults[0].objectId;
        }
        selectFeature(objectId);
        if (addFeatureDiv.style.display === "block"){
          toggleEditingDivs("none", "block");
        }
      }
      // show FeatureTemplates if user deleted a feature
      else if (editsResult.deleteFeatureResults.length > 0){
        toggleEditingDivs("block", "none");
      }
    })
    .catch(function(error) {
        console.log("===============================================");
        console.error("[ applyEdits ] FAILURE: ", error.code, error.name,
          error.message);
        console.log("error = ", error);
      });
  }

});