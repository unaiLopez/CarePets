//Redirreccionar a mostrarMensaje.php pasandole el id del mensaje clicado a la session
$(document).ready(function() {
 $(".list-group .list-group-item").click(function() {
    var id = $(this).attr('id');
    var data = {'id': id};
    $.post('pasarIDaSession.php', data, function(){
        window.location.href = "mostrarMensaje.php";
    });
 });
});

//Responder mensaje desde modal
function responderMensaje(idmensaje, respuesta) {
  var datos = {"idmensaje" : idmensaje, "respuesta" : respuesta};
  $.ajax({
      data: datos,
      url: '/carepets/usuario/mensajeria/responder.php',
      type: 'post',
      async: false,
      success: function(response) {
          alert('Mensaje enviado con exito');
          location.reload(); // then reload the page.(3)

      },
      error: function() {
          alert('No se pudo enviar el mensaje');
      }
  });
}
