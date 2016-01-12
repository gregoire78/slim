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
    autocompletea.addListener('place_changed', function () {
        var place = autocompletea.getPlace();
        var geolocation1 = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        var euo = new google.maps.LatLngBounds(geolocation1);
        autocomplete.setBounds(euo);
        console.log(place.geometry.location.lat(), place.geometry.location.lng());
        console.log(place.formatted_address, autocompletea.getBounds());
        bootstrap_alert.reset("form-city");
        document.getElementById("city").value = place.address_components[1].long_name;
        document.getElementById("postalCode").value = place.address_components[0].long_name;
        document.getElementById("street").value= '';
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
        console.log(place);
        var geolocation = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        var eu = new google.maps.LatLngBounds(geolocation);
        autocompletea.setBounds(eu);
        console.log(place.geometry.location.lat(), place.geometry.location.lng());
        document.getElementById("street").value = place.name;
        document.getElementById("city").value = place.address_components[2].long_name;
        document.getElementById("postalCode").value = place.address_components[6].long_name;
    });
}
google.maps.event.addDomListener(window, 'load', postal_code);
google.maps.event.addDomListener(window, 'load', street);

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