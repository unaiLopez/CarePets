//Redirreccionar a mostrarMensaje.php pasandole el id del mensaje clicado
$(document).ready(function() {
 $(".list-group .list-group-item").click(function() {
   var id = $(this).attr('id');
   window.location.href = "mostrarMensaje.php?id=" + id;
 });
});

//Responder mensaje desde modal
function responderMensaje(idmensaje, respuesta) {
  var bool = false;
  alert("este es el ID del mensaje :");
  alert(idmensaje);
  var datos = {"idmensaje" : idmensaje, "respuesta" : respuesta};
  $.ajax({
      data: datos,
      url: '/carepets/usuario/mensajeria/responder.php',
      type: 'post',
      async: false,
      success: function(response) {
          alert("hecho");
          bool = true;
      },
      error: function() {
          alert('Error');
      }
  });
  return bool;
}
