$(document).ready(function () {
    $("#recuperarBotonTexto").show();
    $("#cargando").hide();
    $(document).ajaxStart(function () {
        $("#cargando").show();
        $("#recuperarBotonTexto").hide();
    }).ajaxStop(function () {
        $("#cargando").hide();
        $("#recuperarBotonTexto").show();
    });
});

function recuperarContraseña(mailusuario) {
  var mail = {"mailusuario" : mailusuario};
  $.ajax({
      data: mail,
      url: '/carepets/usuario/recuperarContraseña.php',
      type: 'post',
      async: false,
      success: function(response) {
        alert(response);
        if(response == true){
          Swal.fire({
            position: 'center',
            type: 'success',
            title: 'Se te ha enviado un mail con tu nueva contraseña',
            showConfirmButton: false,
            timer: 2000
          })
          setTimeout(function(){
            window.location.reload();
          }, 2000)
        }else{
          Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Lo sentimos, algo falló y no se te pudo enviar un mail con tu nueva contraseña',
            showConfirmButton: false,
            timer: 2300
          })
        }
      }
   });
}
