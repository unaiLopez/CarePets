//Responder mensaje desde modal
function responderMensaje(idmensaje, respuesta) {
  var datos = {"idmensaje" : idmensaje, "respuesta" : respuesta};
  $.ajax({
      data: datos,
      url: '/carepets/usuario/mensajeria/responder.php',
      type: 'post',
      async: false,
      success: function(response) {
          alert(response);
          alert('Mensaje enviado con exito');
          location.reload(); // then reload the page

      },
      error: function() {
          alert('No se pudo enviar el mensaje');
      }
  });
}
