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
