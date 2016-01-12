/**
 * Created by gregoire on 8/09/2015.
 */

function initMap() {
    /* MAP */
    var map = new google.maps.Map(document.getElementById('map'), {
        mapTypeId: google.maps.MapTypeId.HYBRID,
        scrollwheel: false,
        //center: {lat: -34.397, lng: 150.644},
        zoom: 19
    });
    var geocoder = new google.maps.Geocoder();
    geocodeAddress(geocoder, map);

    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    });

    /*var ctaLayer = new google.maps.KmlLayer({
     url: 'http://short.thover.com/?ID=521',
     map: map
     });*/
}

function initialize() {
    var fenway = {lat: 42.345573, lng: -71.098326};
    var map = new google.maps.Map(document.getElementById('map'), {
        center: fenway,
        zoom: 14
    });
    var panorama = new google.maps.StreetViewPanorama(
        document.getElementById('pano'), {
            position: fenway,
            pov: {
                heading: 34,
                pitch: 10
            }
        });
    map.setStreetView(panorama);
}

function geocodeAddress(geocoder, resultsMap) {
    var gps;
    var image = {
        url: markerUrl,
        // This marker is 20 pixels wide by 32 pixels high.
        //size: new google.maps.Size(20, 32),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is the base of the flagpole at (0, 32).
        anchor: new google.maps.Point(7, 63)
    };
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            gps = results[0].geometry.location;

            var streetViewService = new google.maps.StreetViewService();
            var STREETVIEW_MAX_DISTANCE = 100;
            streetViewService.getPanoramaByLocation(gps, STREETVIEW_MAX_DISTANCE, function (streetViewPanoramaData, status) {
                if (status === google.maps.StreetViewStatus.OK) {
                    /* STREET VIEW */
                    var panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'), {
                        position: gps,
                        linksControl: false,
                        addressControlOptions: {
                            position: google.maps.ControlPosition.LEFT_BOTTOM
                        },
                        panControl: false,
                        pov: {
                            heading: 265,
                            pitch: 0
                        }
                    });
                    resultsMap.setStreetView(panorama);
                    resultsMap.setCenter(gps);
                } else {
                    document.getElementById('pano').style.display='none';
                    document.getElementById('map').style.width='100%';
                    document.getElementById('map').style.height='100%';
                    google.maps.event.trigger(resultsMap, 'resize');
                    resultsMap.setCenter(gps);
                }
            });


            /* MARKER */
            var marker = new google.maps.Marker({
                map: resultsMap,
                position: gps,
                animation: google.maps.Animation.DROP,
                icon: image,
                //draggable: true,
                title: title
            });

            /* INFO */
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 185
            });
            marker.addListener('click', function () {
                infowindow.open(resultsMap, marker);
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(function(){ marker.setAnimation(null); }, 705);
                }
            });

            var drawingManager = new google.maps.drawing.DrawingManager({
                //drawingMode: google.maps.drawing.OverlayType.MARKER,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.MARKER,
                        google.maps.drawing.OverlayType.CIRCLE,
                        //google.maps.drawing.OverlayType.POLYGON,
                        //google.maps.drawing.OverlayType.POLYLINE,
                        google.maps.drawing.OverlayType.RECTANGLE
                    ]
                },
                //markerOptions: {icon: 'dist/img/Group1.png'},
                circleOptions: {
                    fillColor: '#F00',
                    fillOpacity: 0.5,
                    strokeWeight: 5,
                    clickable: false,
                    editable: true,
                    zIndex: 1
                }
            });
            drawingManager.setMap(resultsMap);

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
$(document).ready(function () {

    /*$('#map').on('mouseover', function () {
        $('#pano').css({
            width: '40%'
        });
        $('#map').css({
            width: '60%'
        });
    }).on('mouseout', function () {
        $('#pano').css({
            width: '50%'
        });
        $('#map').css({
            width: '50%'
        });
    });*/

    /*var ip = '8.8.8.8';
    $.getJSON("http://www.telize.com/geoip/"+ip,
        function(json) {
            console.log("Geolocation information for IP address : ", json.ip);
            console.log("Country : ", json.country);
            console.log("ville : ", json.city);
            console.log("Code postal : ", json.postal_code);
            console.log("Latitude : ", json.latitude);
            console.log("Longitude : ", json.longitude);
            console.log(json);
        }
    );*/
});