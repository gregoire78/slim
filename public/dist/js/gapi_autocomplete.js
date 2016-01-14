/**
 * Created by gregoire on 12/01/2016.
 */
bootstrap_alert();
//&callback=initAutocomplete
var autocompletea, autocomplete;
function postal_code() {
    var input = document.getElementById('postalCode');
    var options = {
        types: ['(regions)'],
        componentRestrictions: {
            country: "fr"
        }
    };
    autocompletea = new google.maps.places.Autocomplete(input, options);
    var markers = [];
    // Clear out the old markers.
    markers.forEach(function(marker) {
        marker.setMap(null);
    });
    markers = [];
    autocompletea.addListener('place_changed', function () {
        var place = autocompletea.getPlace();
        var geolocation1 = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        var bounds = new google.maps.LatLngBounds(geolocation1);
        autocomplete.setBounds(bounds);
        // initialisation de la carte
        if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
        } else {
            bounds.extend(place.geometry.location);
        }
        map.fitBounds(bounds);
        map.setMapTypeId(customMapTypeId);
        //
        //console.log(place.geometry.location.lat(), place.geometry.location.lng());
        //console.log(place.formatted_address, autocompletea.getBounds());
        bootstrap_alert.reset("form-city");
        document.getElementById("city").value = place.address_components[1].long_name;
        document.getElementById("postalCode").value = place.address_components[0].long_name;
        document.getElementById("street").value= '';
        document.getElementById('street').focus();
    });
}

function street() {
    var input = document.getElementById('street');
    var options = {
        types: ['address'],
        componentRestrictions: {
            country: "fr"
        }
    };
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        //console.log(place);
        var geolocation = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        var bounds = new google.maps.LatLngBounds(geolocation);
        autocompletea.setBounds(bounds);
        // initialisation de la carte
        if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
        } else {
            bounds.extend(place.geometry.location);
        }
        map.fitBounds(bounds);
        //map.setMapTypeId(google.maps.MapTypeId.HYBRID);
        map.setZoom(20);
        //
        //console.log(place.geometry.location.lat(), place.geometry.location.lng());
        bootstrap_alert.reset(["form-city", "form-postalcode"], true);
        document.getElementById("street").value = place.name;
        document.getElementById("city").value = place.address_components[2].long_name;
        document.getElementById("postalCode").value = (place.address_components[6].long_name).toUpperCase();
        document.getElementById('phone').focus();
    });
}
google.maps.event.addDomListener(window, 'load', street);
google.maps.event.addDomListener(window, 'load', postal_code);

google.maps.event.addDomListener(document.getElementById('street'), 'keydown', function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
    }
});
google.maps.event.addDomListener(document.getElementById('postalCode'), 'keydown', function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
    }

});

var map, latlng_init, customMapTypeId = 'custom_style', address = address;
function initMap() {
    var customMapType = new google.maps.StyledMapType([{"featureType":"all","elementType":"all","stylers":[{"lightness":"29"},{"invert_lightness":true},{"hue":"#008fff"},{"saturation":"-73"}]},{"featureType":"all","elementType":"labels","stylers":[{"saturation":"-72"}]},{"featureType":"administrative","elementType":"all","stylers":[{"lightness":"32"},{"weight":"0.42"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":"-53"},{"saturation":"-66"}]},{"featureType":"landscape","elementType":"all","stylers":[{"lightness":"-86"},{"gamma":"1.13"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"hue":"#006dff"},{"lightness":"4"},{"gamma":"1.44"},{"saturation":"-67"}]},{"featureType":"landscape","elementType":"geometry.stroke","stylers":[{"lightness":"5"}]},{"featureType":"landscape","elementType":"labels.text.fill","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"weight":"0.84"},{"gamma":"0.5"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"visibility":"off"},{"weight":"0.79"},{"gamma":"0.5"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"simplified"},{"lightness":"-78"},{"saturation":"-91"}]},{"featureType":"road","elementType":"labels.text","stylers":[{"color":"#ffffff"},{"lightness":"-69"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"lightness":"5"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"lightness":"10"},{"gamma":"1"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"lightness":"10"},{"saturation":"-100"}]},{"featureType":"transit","elementType":"all","stylers":[{"lightness":"-35"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"saturation":"-97"},{"lightness":"-14"}]}], {
        name: 'Custom Style'
    });
    customMapTypeId = 'custom_style';
    // geocenter defini dans la vue
    //addresse
    /*var geocenter = {
        center: {lat: 47.02777626053319, lng: 355.3137998046875},
        zoom: 6
    };*/
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        mapTypeId: google.maps.MapTypeId.HYBRID,
        scrollwheel: false,
        //center: geocenterh.center,
        zoom: geocenterh.zoom,
        disableDefaultUI: true,
        draggable: false,
        backgroundColor: '#161617'
    });
    //geocoder une addresse
    if(address != null) {
        var geocoder = new google.maps.Geocoder();
        geocodeAddress(geocoder, map, address);
    }else {
        map.setCenter(geocenterh.center);
        latlng_init = map.getCenter();
    }
    map.mapTypes.set(customMapTypeId, customMapType);
    map.setMapTypeId(customMapTypeId);
}
google.maps.event.addDomListener(window, 'load', initMap);
google.maps.event.addDomListener(window, "resize", function() {
    var center = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(center);
});

function reset_map() {
    var center = map.getCenter();
    //console.log(latlng_init.lng(), center.lng());
    if (center.lat() != latlng_init.lat() || center.lng() != latlng_init.lng()) {
        initMap();
    }
}

function geocodeAddress(geocoder, resultsMap, address) {
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            resultsMap.setZoom(20);
            latlng_init = (results[0].geometry.location);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}