function autocompletar() {

    var input = document.getElementById('autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);
    //Restringir direcciones a España solamente
    autocomplete.setComponentRestrictions({
      'country': ['es']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.formularioRegistro.direccion.value = place.name;
        document.formularioRegistro.latitud.value = place.geometry.location.lat();
        document.formularioRegistro.longitud.value = place.geometry.location.lng();
    });
}

function autocompletarEditar() {

    var input = document.getElementById('autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);
    //Restringir direcciones a España solamente
    autocomplete.setComponentRestrictions({
      'country': ['es']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.formularioCambiarInfoObligatoria.direccion.value = place.name;
        document.formularioCambiarInfoObligatoria.latitud.value = place.geometry.location.lat();
        document.formularioCambiarInfoObligatoria.longitud.value = place.geometry.location.lng();
    });
}

function inicializarMapa() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  var autocomplete = document.getElementById('autocomplete');
  var searchBox = new google.maps.places.Autocomplete(autocomplete);

  //Restringir direcciones a España solamente
  searchBox.setComponentRestrictions({
    'country': ['es']
  });

  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];

  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      if (!place.geometry) {
        console.log("Returned place contains no geometry");
        return;
      }
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}
