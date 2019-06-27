//Responder mensaje desde modal
function responderMensaje(idmensaje, respuesta) {
  var datos = {"idmensaje" : idmensaje, "respuesta" : respuesta};
  $.ajax({
      data: datos,
      url: '/carepets/usuario/mensajeria/responder.php',
      type: 'post',
      async: false,
      success: function(response) {
        if(response == true){
          Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Respuesta enviada con éxito',
            showConfirmButton: false,
            timer: 1500
          })
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
