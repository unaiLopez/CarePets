//Redirreccionar a mostrarMensajeClinica.php pasandole el id del mensaje clicado a la session
$(document).ready(function() {
 $(".list-group .list-group-item").click(function() {
    var id = $(this).attr('id');
    var data = {'id': id};
    $.post('pasarIDaSession.php', data, function(){
        window.location.href = "mostrarMensajeClinica.php";
    });
 });
});
