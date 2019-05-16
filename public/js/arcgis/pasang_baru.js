
var lat = null;
var long = null;
navigator.geolocation.getCurrentPosition(function (res) {
  lat = res.coords.latitude;
  long = res.coords.longitude;
});

require([
  "esri/Map",
  "esri/views/MapView",
  "esri/views/2d/draw/Draw",
  "esri/Graphic",
  "esri/geometry/geometryEngine",
  "esri/layers/FeatureLayer",
], function(
  Map, MapView, Draw, Graphic, geometryEngine, FeatureLayer
) {
  const map = new Map({
    basemap: "topo"
  });

  const view = new MapView({
    container: "viewDiv",
    map: map,
    zoom: 12,
    center: [long, lat]
  });

  // add the button for the draw tool
  view.ui.add("line-button", "top-left");

  const draw = new Draw({
    view: view
  });

  var url = "https://gis.pdam-sby.go.id/server/rest/services/Data_Spasial/GISPDAM_SURABAYA/FeatureServer/8";
  var featureLayer = new FeatureLayer({
      url: url,
      outFields: ["*"]
    });
  map.add(featureLayer);

  // draw polyline button
  document.getElementById("line-button").onclick = function() {
    view.graphics.removeAll();

    // creates and returns an instance of PolyLineDrawAction
    const action = draw.create("polyline");

    // focus the view to activate keyboard shortcuts for sketching
    view.focus();

    // listen polylineDrawAction events to give immediate visual feedback
    // to users as the line is being drawn on the view.
    action.on(["vertex-add", "vertex-remove", "cursor-update", "redo",
      "undo", "draw-complete"
    ], updateVertices);
  }

  // Checks if the last vertex is making the line intersect itself.
  function updateVertices(event) {
    // create a polyline from returned vertices
    const result = createGraphic(event);

    // if the last vertex is making the line intersects itself,
    // prevent the events from firing
    if (result.selfIntersects) {
      event.preventDefault();
    }
  }

  // create a new graphic presenting the polyline that is being drawn on the view
  function createGraphic(event) {
    const vertices = event.vertices;
    view.graphics.removeAll();

    // a graphic representing the polyline that is being drawn
    const graphic = new Graphic({
      geometry: {
        type: "polyline",
        paths: vertices,
        spatialReference: view.spatialReference
      },
      symbol: {
        type: "simple-line", // autocasts as new SimpleFillSymbol
        color: [133, 91, 0],
        width: 2,
        cap: "round",
        join: "round"
      }
    });

    // check if the polyline intersects itself.
    const intersectingSegment = getIntersectingSegment(graphic.geometry);

    // Add a new graphic for the intersecting segment.
    if (intersectingSegment) {
      view.graphics.addMany([graphic, intersectingSegment]);
    }
    // Just add the graphic representing the polyline if no intersection
    else {
      view.graphics.add(graphic);

      const edits = {
        addFeatures: [graphic]
      };
      applyEditsToIncidents(edits);
    }

    // return intersectingSegment
    return {
      selfIntersects: intersectingSegment
    }
  }

  // function that checks if the line intersects itself
  function isSelfIntersecting(polyline) {
    if (polyline.paths[0].length < 3) {
      return false
    }
    const line = polyline.clone();

    //get the last segment from the polyline that is being drawn
    const lastSegment = getLastSegment(polyline);
    line.removePoint(0, line.paths[0].length - 1);

    // returns true if the line intersects itself, false otherwise
    return geometryEngine.crosses(lastSegment, line);
  }

  // Checks if the line intersects itself. If yes, change the last
  // segment's symbol giving a visual feedback to the user.
  function getIntersectingSegment(polyline) {
    if (isSelfIntersecting(polyline)) {
      return new Graphic({
        geometry: getLastSegment(polyline),
        symbol: {
          type: "simple-line", // autocasts as new SimpleLineSymbol
          style: "short-dot",
          width: 3.5,
          color: "yellow"
        }
      });
    }
    return null;
  }

  // Get the last segment of the polyline that is being drawn
  function getLastSegment(polyline) {
    const line = polyline.clone();
    const lastXYPoint = line.removePoint(0, line.paths[0].length - 1);
    const existingLineFinalPoint = line.getPoint(0, line.paths[0].length -
      1);

    return {
      type: "polyline",
      spatialReference: view.spatialReference,
      hasZ: false,
      paths: [
        [
          [existingLineFinalPoint.x, existingLineFinalPoint.y],
          [lastXYPoint.x, lastXYPoint.y]
        ]
      ]
    };
  }

  // Call FeatureLayer.applyEdits() with specified params.
  function applyEditsToIncidents(params) {
    // unselectFeature();
    featureLayer.applyEdits(params).then(function(editsResult) {
      // Get the objectId of the newly added feature.
      // Call selectFeature function to highlight the new feature.
      if (editsResult.addFeatureResults.length > 0 || editsResult.updateFeatureResults.length > 0) {
        // unselectFeature();
        let objectId;
        if (editsResult.addFeatureResults.length > 0) {
          objectId = editsResult.addFeatureResults[0].objectId;
        }
        else {
          featureForm.feature = null;
          objectId = editsResult.updateFeatureResults[0].objectId;
        }
        // selectFeature(objectId);
        // if (addFeatureDiv.style.display === "block"){
        //   toggleEditingDivs("none", "block");
        // }
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