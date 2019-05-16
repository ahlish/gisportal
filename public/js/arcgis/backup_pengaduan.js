var lat = null;
var long = null;
navigator.geolocation.getCurrentPosition(function (res) {
  lat = res.coords.latitude;
  long = res.coords.longitude;
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
"esri/geometry/Point"
],
function(
Map, MapView, FeatureLayer, Graphic, Expand,
FeatureForm, FeatureTemplates, Search, SimpleMarkerSymbol, SimpleLineSymbol, Color, Point
) {

  let editFeature, highlight, view;

  // const featureLayer = new FeatureLayer({
  //   url: "https://gis.pdam-sby.go.id/server/rest/services/trial_pengaduan/FeatureServer/0",
  //   outFields: ["*"],
  //   popupEnabled: false,
  //   id: "incidentsLayer"
  // });

  // const pipeFeatureLayer = new FeatureLayer({
  //   url: "https://gis.pdam-sby.go.id/server/rest/services/Data_Spasial/GISPDAM_SURABAYA/FeatureServer/8",
  //   outFields: ["*"],
  //   popupEnabled: false,
  //   id: "pipeLayer"
  // });

  const map = new Map({
    basemap: "topo",
    // layers: [featureLayer, pipeFeatureLayer],
    layers: [],
    // center: [long, lat],
    // center: [112.73333, -7.23333],
    // zoom: 13
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

  var pt = new Point({
    x: 348.20001220703125,
    y: 297.4000244140625,
    spatialReference: 2027
  });

  var pictureGraphic = new Graphic({
   geometry: {
     type: "point",
    x: 348.20001220703125,
    y: 297.4000244140625,
   },
   symbol: {
     type: "picture-marker",
     url: "https://developers.arcgis.com/labs/images/bluepin.png",
     width: "14px",
     height: "26px"
   }
 });

 view.graphics.add(pictureGraphic);

  // view.graphics.add(pt);

  view.on('click', function(e){
    alert("clicked");
    var coordinates = [e.x, e.y, e.mapPoint.latitude, e.mapPoint.longitude];

    createPointGraphic(coordinates);
  });

  function createPointGraphic(coordinates){
    view.graphics.removeAll();
    var point = {
      type: "point", // autocasts as /Point
      x: coordinates[0],
      y: coordinates[1],
      spatialReference: view.spatialReference
    };

    var graphic = new Graphic({
      geometry: point,
      symbol: {
        type: "simple-marker", // autocasts as SimpleMarkerSymbol
        style: "square",
        color: "red",
        size: "16px",
        outline: { // autocasts as SimpleLineSymbol
          color: [255, 255, 0],
          width: 3
        }
      }
    });
    view.graphics.add(graphic);
    document.getElementById("latitude").value = coordinates[2];
    document.getElementById("longitude").value = coordinates[3];
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

  // New FeatureForm and set its layer to 'Incidents' FeatureLayer.
  // FeatureForm displays attributes of fields specified in fieldConfig.
  // const featureForm = new FeatureForm({
  //   container: "formDiv",
  //   layer: featureLayer,
  //   fieldConfig: [
  //     {
  //       name: "nopengaduan",
  //       label: "Nomor Pengaduan"
  //     },
  //   ]
  // });

  // Listen to the feature form's submit event.
  // Update feature attributes shown in the form.
  // featureForm.on("submit", function(){
  //   if (editFeature) {
  //     // Grab updated attributes from the form.
  //     const updated = featureForm.getValues();

  //     // Loop through updated attributes and assign
  //     // the updated values to feature attributes.
  //     Object.keys(updated).forEach(function(name) {
  //       editFeature.attributes[name] = updated[name];
  //     });

  //     // Setup the applyEdits parameter with updates.
  //     const edits = {
  //       updateFeatures: [editFeature]
  //     };
  //     applyEditsToIncidents(edits);
  //     document.getElementById("viewDiv").style.cursor = "auto"
  //   }
  // });

  // Check if the user clicked on the existing feature
  // selectExistingFeature();

  // The FeatureTemplates widget uses the 'addTemplatesDiv'
  // element to display feature templates from incidentsLayer
  // const templates = new FeatureTemplates({
  //   container: "addTemplatesDiv",
  //   layers: [featureLayer]
  // });

  // Listen for when a template item is selected
  // templates.on("select", function(evtTemplate) {

  //   // Access the template item's attributes from the event's
  //   // template prototype.
  //   attributes = evtTemplate.template.prototype.attributes;
  //   unselectFeature();
  //   document.getElementById("viewDiv").style.cursor = "crosshair";

  //   // With the selected template item, listen for the view's click event and create feature
  //   const handler = view.on("click", function(event) {
  //     // remove click event handler once user clicks on the view
  //     // to create a new feature
  //     handler.remove();
  //     event.stopPropagation();
  //     featureForm.feature = null;

  //     if (event.mapPoint) {
  //       point = event.mapPoint.clone();
  //       point.z = undefined;
  //       point.hasZ = false;

  //       // Create a new feature using one of the selected
  //       // template items.
  //       editFeature = new Graphic({
  //         geometry: point,
  //         attributes: {
  //           "IncidentType": attributes.IncidentType
  //         }
  //       });

  //       // Setup the applyEdits parameter with adds.
  //       const edits = {
  //         addFeatures: [editFeature]
  //       };
  //       applyEditsToIncidents(edits);
  //       document.getElementById("viewDiv").style.cursor = "auto";
  //     } else {
  //       console.error("event.mapPoint is not defined");
  //     }
  //   });
  // });

  // Call FeatureLayer.applyEdits() with specified params.
  // function applyEditsToIncidents(params) {
  //   // unselectFeature();
  //   featureLayer.applyEdits(params).then(function(editsResult) {
  //     // Get the objectId of the newly added feature.
  //     // Call selectFeature function to highlight the new feature.
  //     if (editsResult.addFeatureResults.length > 0 || editsResult.updateFeatureResults.length > 0) {
  //       unselectFeature();
  //       let objectId;
  //       if (editsResult.addFeatureResults.length > 0) {
  //         objectId = editsResult.addFeatureResults[0].objectId;
  //       }
  //       else {
  //         featureForm.feature = null;
  //         objectId = editsResult.updateFeatureResults[0].objectId;
  //       }
  //       selectFeature(objectId);
  //       if (addFeatureDiv.style.display === "block"){
  //         toggleEditingDivs("none", "block");
  //       }
  //     }
  //     // show FeatureTemplates if user deleted a feature
  //     else if (editsResult.deleteFeatureResults.length > 0){
  //       toggleEditingDivs("block", "none");
  //     }
  //   })
  //   .catch(function(error) {
  //       console.log("===============================================");
  //       console.error("[ applyEdits ] FAILURE: ", error.code, error.name,
  //         error.message);
  //       console.log("error = ", error);
  //     });
  // }

  // Check if a user clicked on an incident feature.
  // function selectExistingFeature() {
  //   view.on("click", function(event) {
  //     // clear previous feature selection
  //     unselectFeature();
  //     if (document.getElementById("viewDiv").style.cursor != "crosshair") {
  //       view.hitTest(event).then(function(response) {
  //         // If a user clicks on an incident feature, select the feature.
  //         if (response.results.length === 0) {
  //           toggleEditingDivs("block", "none");
  //         }
  //         else if (response.results[0].graphic && response.results[0].graphic.layer.id == "incidentsLayer") {
  //           if (addFeatureDiv.style.display === "block"){
  //             toggleEditingDivs("none", "block");
  //           }
  //           selectFeature(response.results[0].graphic.attributes[featureLayer.objectIdField]);
  //         }
  //       });
  //     }
  //   });
  // }

  // Highlights the clicked feature and display
  // the feature form with the incident's attributes.
  // function selectFeature(objectId) {
  //   // query feature from the server
  //   featureLayer.queryFeatures({
  //     objectIds: [objectId],
  //     outFields: ["*"],
  //     returnGeometry: true
  //   }).then(function(results) {
  //     if (results.features.length > 0) {
  //       editFeature = results.features[0];

  //       // display the attributes of selected feature in the form
  //       featureForm.feature = editFeature;

  //       // highlight the feature on the view
  //       view.whenLayerView(editFeature.layer).then(function(layerView){
  //         highlight = layerView.highlight(editFeature);
  //       });
  //     }
  //   });
  // }

  // Expand widget for the editArea div.
  // const editExpand = new Expand({
  //   expandIconClass: "esri-icon-edit",
  //   expandTooltip: "Expand Edit",
  //   expanded: true,
  //   view: view,
  //   content: document.getElementById("editArea")
  // });

  // // view.ui.add(editExpand, "top-right");
  // // input boxes for the attribute editing
  // const addFeatureDiv = document.getElementById("addFeatureDiv");
  // const attributeEditing = document.getElementById("featureUpdateDiv");

  // Controls visibility of addFeature or attributeEditing divs
  // function toggleEditingDivs(addDiv, attributesDiv) {
  //   addFeatureDiv.style.display = addDiv;
  //   attributeEditing.style.display = attributesDiv;

  //   document.getElementById("updateInstructionDiv").style.display = addDiv;
  // }

  // // Remove the feature highlight and remove attributes
  // // from the feature form.
  // function unselectFeature() {
  //   if (highlight){
  //     highlight.remove();
  //   }
  // }

  // // Update attributes of the selected feature.
  // document.getElementById("btnUpdate").onclick = function() {
  //   // Fires feature form's submit event.
  //   featureForm.submit();
  // }

  // // Delete the selected feature. ApplyEdits is called
  // // with the selected feature to be deleted.
  // document.getElementById("btnDelete").onclick = function() {
  //   // setup the applyEdits parameter with deletes.
  //   const edits = {
  //     deleteFeatures: [editFeature]
  //   };
  //   applyEditsToIncidents(edits);
  //   document.getElementById("viewDiv").style.cursor = "auto";
  // }
});