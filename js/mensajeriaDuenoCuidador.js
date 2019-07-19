//Redirreccionar a mostrarMensajeDuenoCuidador.php pasandole el id del mensaje clicado a la session
$(document).ready(function() {
   $("#solicitudes").hide();
   $("#mensajesRecibidos").hide();
   $("#mensajesEnviados").show();
   $(".list-group .list-group-item").click(function() {
      var id = $(this).attr('id');
      var data = {'id': id};
      $.post('pasarIDaSession.php', data, function(){
          window.location.href = "mostrarMensajeDuenoCuidador.php";
      });
   });
});

function mostrarTabMensajesRecibidos(){
  $("#mensajesEnviados").hide();
  $("#solicitudes").hide();
  $("#mensajesRecibidos").show();
}

function mostrarTabSolicitudes(){
  $("#mensajesRecibidos").hide();
  $("#mensajesEnviados").hide();
  $("#solicitudes").show();
}

function mostrarTabMensajesEnviados(){
  $("#solicitudes").hide();
  $("#mensajesRecibidos").hide();
  $("#mensajesEnviados").show();
}

function rechazarSolicitud(idmensaje) {
  var datos = {"idmensaje" : idmensaje};
  $.ajax({
      data: datos,
      url: '/carepets/usuario/busqueda/rechazarSolicitud.php',
      type: 'post',
      async: false,
      success: function(response) {
        if(response == true){
          Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Solicitud Rechazada',
            showConfirmButton: false,
            timer: 1500
          })
          setTimeout(function(){
            window.location.reload();
          }, 1500)
        }else{
          Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Lo sentimos, no se pudo enviar la respuesta con éxito',
            showConfirmButton: false,
            timer: 2300
          })
        }
      }
   });
}

function aceptarSolicitud(idmensaje) {
  var datos = {"idmensaje" : idmensaje};
  $.ajax({
      data: datos,
      url: '/carepets/usuario/busqueda/aceptarSolicitud.php',
      type: 'post',
      async: false,
      success: function(response) {
        if(response == true){
          Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Solicitud Aceptada',
            showConfirmButton: false,
            timer: 1500
          })
          setTimeout(function(){
            window.location.reload();
          }, 1500)
        }else{
          Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Lo sentimos, no se pudo enviar la respuesta con éxito',
            showConfirmButton: false,
            timer: 2300
          })
        }
      }
   });
}
