var layerCarPath;
var layerCarMarkers;

// Constructor of the OpenStreetMap
function osmInit(lat, lon, zoom) {
    try {
        maps[0] = null;
        maps[1] = null;

        if(map!=null) {
            if(map instanceof VEMap) {
                map.Dispose();
                map = null;
            } else if (map instanceof GMap2) {
                DisposeMap();
            }
        }
        if(CURRENT_DIV == HISTORY) {
            var mapName = "theHisMap";
        } else {
            var mapName = "theMap";
        }
    } catch(e) {
        var mapName = "theMap";
    }

    if(map==null) {
        map = new OpenLayers.Map (mapName, {
            controls:[
                new OpenLayers.Control.Navigation(),
                new OpenLayers.Control.PanZoomBar(),
                new OpenLayers.Control.LayerSwitcher(),
                new OpenLayers.Control.Attribution()],
                maxExtent: new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34),
                maxResolution: 156543.0399,
                numZoomLevels: 19,
                units: 'm',
            projection: new OpenLayers.Projection("EPSG:900913"),
            displayProjection: new OpenLayers.Projection("EPSG:4326")
        } );

        osmAddMap_Layers();
    }

    if (arrMapLocation.length > 0) {
        osmOneCarMarker(arrMapLocation[0].mapLat, arrMapLocation[0].mapLon, arrMapLocation[0].speed, arrMapLocation[0].str);
        var dzoom = map.getZoom()
        if (dzoom < 10) { dzoom = 10 }
        osmMapCenter(arrMapLocation[0].mapLat, arrMapLocation[0].mapLon, dzoom)
        osmAddVectorLayer();

    } else {
        osmMapCenter(lat, lon, zoom);
        layerCarMarkers.clearMarkers();
    }
}

// Define the map layers
function osmAddMap_Layers() {
    layerMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik");
    map.addLayer(layerMapnik);
    layerTilesAtHome = new OpenLayers.Layer.OSM.Osmarender("Osmarender");
    map.addLayer(layerTilesAtHome);
    layerCycleMap = new OpenLayers.Layer.OSM.CycleMap("CycleMap");
    map.addLayer(layerCycleMap);
    osmAddCar_Layer();
}

// Add the layer for the car markers
function osmAddCar_Layer() {
    layerCarMarkers = new OpenLayers.Layer.Markers("Car Marker");
    map.addLayer(layerCarMarkers);
}

// Add the GPX Track Layer
function osmAddGPX_Layer(gpxurl) {
    layerCarPath = new OpenLayers.Layer.GML("GPX Path", gpxurl, {
        format: OpenLayers.Format.GPX,
        style: {strokeColor: "red", strokeWidth: 5, strokeOpacity: 0.5},
        projection: new OpenLayers.Projection("EPSG:4326")
    });
    map.addLayer(layerCarPath);
    osmAddCar_Layer();
}

// Add the Vector Path Layer
function osmAddVectorLayer(){
    if (layerCarPath != undefined) {
        layerCarPath.destroy();
    }
    if (arrMapLocation.length > 1) {
        layerCarPath = new OpenLayers.Layer.Vector("Car Path");

        var pointList = [];
        for(var y = 0; y < arrMapLocation.length; y++)
        {
            var lonLat = new OpenLayers.LonLat(arrMapLocation[y].mapLon, arrMapLocation[y].mapLat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
            pointList.push(new OpenLayers.Geometry.Point(lonLat.lon, lonLat.lat));
        }

        var lineFeature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.LineString(pointList),null,{strokeColor: "#FF0000"});

        map.addLayer(layerCarPath);
        layerCarPath.addFeatures([lineFeature]);
    }
}

// Move the center of the map to the given coordinates
function osmMapCenter(lat, lon, zoom) {
    var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
    map.setCenter(lonLat, zoom);
}

// Get the Icon for the carMarker
function carIcon() {
    var CarMarkerIcon = 'http://www.openstreetmap.org/openlayers/img/marker.png'
    //Dimensions of the icon, must match CarMarkerIcon
    var size = new OpenLayers.Size(21, 25);
    var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
    return new OpenLayers.Icon(CarMarkerIcon, size, offset);
}

// only one carMarker on the given coordinates
function osmOneCarMarker(lat, lon, speed, popupContentHTML) {
    layerCarMarkers.clearMarkers();
    osmAddCarMarker(lat, lon, speed, popupContentHTML);
}

// Add a Car Marker
function osmAddCarMarker(lat, lon, speed, popupContentHTML) {
    var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
    while( map.popups.length ) {
         map.removePopup(map.popups[0]);
    }
    var feature = new OpenLayers.Feature(layerCarMarkers, lonLat);
    feature.closeBox = true;
    var AutoSizeFramedCloud = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {'autoSize': true});
    feature.popupClass = AutoSizeFramedCloud;
    feature.data.popupContentHTML = popupContentHTML;
    feature.data.overflow = "auto";

    var size = new OpenLayers.Size(50,50);
    var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
    var icon = new OpenLayers.Icon(GetImageName(speed), size, offset);
    feature.data.icon = icon

    var marker = feature.createMarker();

    var markerClick = function (evt) {
        if (this.popup == null) {
            this.popup = this.createPopup(this.closeBox);
            map.addPopup(this.popup, true);
            this.popup.show();
        } else {
            this.popup.toggle();
        }
        OpenLayers.Event.stop(evt);
    };
    marker.events.register("mousedown", feature, markerClick);

    layerCarMarkers.addMarker(marker);
    //layerCarMarkers.addMarker(new OpenLayers.Marker(lonLat, carIcon()));

}

// Change the car path
function osmChangeCarPath(gpxurl) {
    if (layerCarPath == undefined) {
        osmAddGPX_Layer(gpxurl);
    } else {
        layerCarPath.setUrl(gpxurl);
    }
}



// Functions to control visibility of the carMarker layer
function osmShowCarMarker() {
    layerCarMarkers.setVisibility(true);
}
function osmHideCarMarker() {
    layerCarMarkers.setVisibility(false);
}
function osmAlternateCarMarker() {
    layerCarMarkers.setVisibility(!layerCarMarkers.getVisibility());
}

// Functions to control visibility of the carPath layer
function osmShowCarPath() {
    layerCarPath.setVisibility(true);
}
function osmHideCarPath() {
    layerCarPath.setVisibility(false);
}
function osmAlternateCarPath() {
    layerCarPath.setVisibility(!layerCarPath.getVisibility());
}



// Sample function
function osmChangeCar(selectObj) {
    var zoom = 10
    var vehicle = selectObj.options[selectObj.selectedIndex].value
    if (vehicle == "Car1") {
        var lat = 38;
        var lon = 21.5;
        var gpxurl = "test1.gpx.txt";
    } else if (vehicle == "Car2") {
        var lat = 38.15;
        var lon = 22.2;
        var gpxurl = "test2.gpx.txt";
    } else if (vehicle == "Car3") {
        var lat = 37;
        var lon = 21.7;
        var gpxurl = "test3.gpx.txt";
    }
    osmMapCenter(lat, lon, zoom);
    osmChangeCarPath(gpxurl)
    osmOneCarMarker(lat, lon, 60, "Sample car");
}