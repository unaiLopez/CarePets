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
