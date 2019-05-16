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
    "esri/widgets/FeatureForm",
    "esri/geometry/Polyline",
    "dojo/on",
    "dojo/dom",
    "dojo/dom-style",
    "dojo/mouse",
    "dojo/domReady!",
    "esri/widgets/Expand",
    "esri/widgets/FeatureTemplates"
  ], function(
    Map, MapView, Draw, Graphic, geometryEngine, FeatureLayer, FeatureForm, Polyline, on, dom, domStyle, mouse, Expand, FeatureTemplates
  ) {

    let editFeatures, highlight;

    const map = new Map({
      basemap: "topo"
    });

    const view = new MapView({
      container: "viewDiv",
      map: map,
      zoom: 12,
      center: [long, lat]
    });

    const draw = new Draw({
      view: view
    });

    var url = "https://gis.pdam-sby.go.id/server/rest/services/TrialWebgisLinestring_2/FeatureServer/0";
    var featureLayer = new FeatureLayer({
        url: url,
        outFields: ["*"],
        // popupTemplate: template
        id: "incidentsLayer"
      });
    map.add(featureLayer);

    // function doUpdate() {
    var myButton = dom.byId("updateLine");

    // New FeatureForm and set its layer to 'Incidents' FeatureLayer.
    // FeatureForm displays attributes of fields specified in fieldConfig.
    const featureForm = new FeatureForm({
      container: "formDiv",
      layer: featureLayer,
      fieldConfig: [
        {
          name: "NOLANG",
          label: "Nomor Pelanggan / Pelanggan"
        },
        {
          name: "NAME",
          label: "Nama Pelapor / Pelanggan"
        }
      ]
    });

    // Check if the user clicked on the existing feature
    selectExistingFeature();

    // The FeatureTemplates widget uses the 'addTemplatesDiv'
    // element to display feature templates from incidentsLayer
    const templates = new FeatureTemplates({
      container: "addTemplatesDiv",
      layers: [featureLayer]
    });

    // Listen for when a template item is selected
    templates.on("select", function(evtTemplate) {

      // Access the template item's attributes from the event's
      // template prototype.
      attributes = evtTemplate.template.prototype.attributes;
      unselectFeature();
      document.getElementById("viewDiv").style.cursor = "crosshair";

      // With the selected template item, listen for the view's click event and create feature
      const handler = view.on("click", function(event) {
        // remove click event handler once user clicks on the view
        // to create a new feature
        handler.remove();
        event.stopPropagation();
        featureForm.feature = null;

        if (event.mapPoint) {
          point = event.mapPoint.clone();
          point.z = undefined;
          point.hasZ = false;

          // Create a new feature using one of the selected
          // template items.
          editFeature = new  Graphic({
            geometry: point,
            attributes: {
              "IncidentType": attributes.IncidentType
            }
          });

          // Setup the applyEdits parameter with adds.
          const edits = {
            addFeatures: [editFeature]
          };
          applyEditsToIncidents(edits);
          document.getElementById("viewDiv").style.cursor = "auto";
        } else {
          console.error("event.mapPoint is not defined");
        }
      });
    });

    // Update attributes of the selected feature.
    document.getElementById("btnUpdate").onclick = function() {
      // Fires feature form's submit event.
      featureForm.submit();
    }

    // Delete the selected feature. ApplyEdits is called
    // with the selected feature to be deleted.
    document.getElementById("btnDelete").onclick = function() {
      // setup the applyEdits parameter with deletes.
      const edits = {
        deleteFeatures: [editFeature]
      };
      applyEditsToIncidents(edits);
      document.getElementById("viewDiv").style.cursor = "auto";
    }

    // Listen to the feature form's submit event.
    // Update feature attributes shown in the form.
    featureForm.on("submit", function(){
      if (editFeature) {
        // Grab updated attributes from the form.
        const updated = featureForm.getValues();

        // Loop through updated attributes and assign
        // the updated values to feature attributes.
        Object.keys(updated).forEach(function(name) {
          editFeature.attributes[name] = updated[name];
        });

        // Setup the applyEdits parameter with updates.
        const edits = {
          updateFeatures: [editFeature]
        };
        applyEditsToIncidents(edits);
        document.getElementById("viewDiv").style.cursor = "auto"
      }
    });

    // Check if a user clicked on an incident feature.
    function selectExistingFeature() {
      view.on("click", function(event) {
        // clear previous feature selection
        unselectFeature();
        if (document.getElementById("viewDiv").style.cursor != "crosshair") {
          view.hitTest(event).then(function(response) {
            // If a user clicks on an incident feature, select the feature.
            if (response.results.length === 0) {
              toggleEditingDivs("block", "none");
            }
            else if (response.results[0].graphic && response.results[0].graphic.layer.id == "incidentsLayer") {
              if (addFeatureDiv.style.display === "block"){
                toggleEditingDivs("none", "block");
              }
              selectFeature(response.results[0].graphic.attributes[featureLayer.objectIdField]);
            } else if (response.results[0].graphic) {
              if (addFeatureDiv.style.display === "block"){
                toggleEditingDivs("none", "block");
              }
              selectFeature(response.results[1].graphic.attributes[featureLayer.objectIdField]);
              // selectFeature(event.data.data.features[0].attributes[featureLayer.objectIdField]);
            }
          });
        }
      });
    }

    // Highlights the clicked feature and display
    // the feature form with the incident's attributes.
    function selectFeature(objectId) {
      // query feature from the server
      // alert(objectId);
      featureLayer.queryFeatures({
        objectIds: [objectId],
        outFields: ["*"],
        returnGeometry: true
      }).then(function(results) {
        if (results.features.length > 0) {
          editFeature = results.features[0];
          document.getElementById('editArea').style.display = '';

          // display the attributes of selected feature in the form
          featureForm.feature = editFeature;

          // highlight the feature on the view
          view.whenLayerView(editFeature.layer).then(function(layerView){
            highlight = layerView.highlight(editFeature);
          });
        }
      });
    }

    // input boxes for the attribute editing
    const addFeatureDiv = document.getElementById("addFeatureDiv");
    const attributeEditing = document.getElementById("featureUpdateDiv");

    // Controls visibility of addFeature or attributeEditing divs
    function toggleEditingDivs(addDiv, attributesDiv) {
      addFeatureDiv.style.display = addDiv;
      attributeEditing.style.display = attributesDiv;

      document.getElementById("updateInstructionDiv").style.display = addDiv;
    }

    // Remove the feature highlight and remove attributes
    // from the feature form.
    function unselectFeature() {
      if (highlight){
        highlight.remove();
        document.getElementById("editArea").style.display = 'none';
      }
    }

    // Call FeatureLayer.applyEdits() with specified params.
    function applyAttributeUpdates(params) {
      document.getElementById("btnUpdate").style.cursor = "progress";
      featureLayer.applyEdits(params).then(function(editsResult) {
          // Get the objectId of the newly added feature.
          // Call selectFeature function to highlight the new feature.
          if (editsResult.addFeatureResults.length > 0) {
            const objectId = editsResult.addFeatureResults[0].objectId;
            selectFeature(objectId);
          }
          document.getElementById("btnUpdate").style.cursor = "pointer";
        })
        .catch(function(error) {
          console.log("===============================================");
          console.error("[ applyEdits ] FAILURE: ", error.code, error.name,
            error.message);
          console.log("error = ", error);
          document.getElementById("btnUpdate").style.cursor = "pointer";
        });
    }

    // add the button for the draw tool
    view.ui.add("line-button", "top-left");
    // view.ui.add("point-button", "top-left");


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
        "undo"
      ], updateVertices);
      action.on("draw-complete", update2);
    }

    function update2(event) {
      var graphic = new Polyline({
        paths: event.vertices,
        spatialReference: 3857
      });

      var data = {
        geometry: graphic,
        attributes: {NAME: null, DATECREATED :null, NOLANG:null}
      };

      const edits = {
        addFeatures: [data]
      };

      applyEditsToIncidents(edits);
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
          color: [72, 49, 146],
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
        console.log(edits);
        // applyEditsToIncidents(edits);
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
          view.graphics.removeAll();
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