$(document).ready(function() {
    $('.borrarAnimal').click(function(){
        var id = $(this).attr('id');
        var data = {"id" : id};
        $.ajax({
            data: data,
            url: '/carepets/usuario/editar/borrarAnimalAdopcion.php',
            type: 'post',
            async: false,
            success: function(response) {
              if(response == true){
                Swal.fire({
                  position: 'center',
                  type: 'success',
                  title: 'El animal se ha borrado con éxito',
                  showConfirmButton: false,
                  timer: 1500
                })
              }else{
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Lo sentimos, no se pudo borrar el animal con éxito',
                  showConfirmButton: false,
                  timer: 2300
                })
              }
            }
        });
    });
    $('.editarAnimal').click(function(){
        var id = $(this).attr('id');
        var data = {'id': id};
        var tipo = 'Editar';
        $.post('/carepets/usuario/editar/pasarAnimalIDaSesion.php', data, function(){
            window.location.href = '/carepets/usuario/editar/editarAñadirAnimalAdopcion.php?tipo='+tipo+'&id='+id;
        });
    });
    $('.adoptarAnimal').click(function(){
        var id = $(this).attr('id');
        var mailUsuarioServicio = $(this).attr('value');
        var data = {"id" : id, "mailUsuarioServicio" : mailUsuarioServicio};
        $.ajax({
            data: data,
            url: '/carepets/usuario/editar/enviarSolicitudAdopcion.php',
            type: 'post',
            async: false,
            success: function(response) {
              if(response == true){
                Swal.fire({
                  position: 'center',
                  type: 'success',
                  title: 'Solicitud de adopción enviada con éxito',
                  showConfirmButton: false,
                  timer: 1500
                })
              }else{
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Lo sentimos, no se pudo enviar la solicitud de adopción con éxito',
                  showConfirmButton: false,
                  timer: 2300
                })
              }
            }
        });
    });
});

function redireccionarAñadirAnimal() {
  var tipo = 'Añadir';
  window.location.href = '/carepets/usuario/editar/editarAñadirAnimalAdopcion.php?tipo='+tipo;
}
