function cambiarInterfaces(){
  var opcionSeleccionadaTipo = $('#buscarTipo option:selected');
  var opcionSeleccionadaServicio = $('#elegirServicio option:selected');
  var tipo = opcionSeleccionadaTipo.text();
  var servicio = opcionSeleccionadaServicio.text();
  if(tipo == 'Cuidador'){
    $('#tiposServicios').show();
    $('#informacionServicios').show();
    $('#informacionClinicas').hide();
    $('#informacionProtectoras').hide();
    if(servicio == 'Alojamiento'){
      $('#fecha1').show();
      $('#fecha2').show();
      $('#fecha3').hide();
    }else if(servicio == 'Cuidado de Día'){
      $('#fecha1').hide();
      $('#fecha2').hide();
      $('#fecha3').show();
    }else if(servicio == 'Paseo'){
      $('#fecha1').hide();
      $('#fecha2').hide();
      $('#fecha3').show();
    }else if(servicio == 'Visita a Domicilio'){
      $('#fecha1').hide();
      $('#fecha2').hide();
      $('#fecha3').show();
    }
  }else if(tipo == 'Clinica Veterinaria'){
    $('#tiposServicios').hide();
    $('#informacionServicios').hide();
    $('#fecha1').hide();
    $('#fecha2').hide();
    $('#fecha3').hide();
    $('#informacionClinicas').show();
    $('#informacionProtectoras').hide();
    servicio = 'Alojamiento';
  }else if(tipo == 'Protectora de Animales'){
    $('#tiposServicios').hide();
    $('#informacionServicios').hide();
    $('#fecha1').hide();
    $('#fecha2').hide();
    $('#fecha3').hide();
    $('#informacionClinicas').hide();
    $('#informacionProtectoras').show();
    servicio = 'Alojamiento';
  }
}

function mostrarInicio() {
  $('#tiposServicios').show();
  $('#informacionServicios').show();
  $('#fecha1').show();
  $('#fecha2').show();
  $('#fecha3').hide();
  $('#informacionClinicas').hide();
  $('#informacionProtectoras').hide();
}

$(function() {
  $('.dates #usr1').datepicker({
    'format': 'yyyy-mm-dd',
    'autoclose': true
  });
});
