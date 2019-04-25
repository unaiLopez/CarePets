//Redirreccionar a mostrarMensaje.php pasandole el id del mensaje clicado
$(document).ready(function() {
 $(".list-group .list-group-item").click(function() {
   var id = $(this).attr('id');
   window.location.href = "mostrarMensaje.php?id=" + id;
 });
});
