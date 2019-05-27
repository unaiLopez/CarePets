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
                alert("El animal se ha borrado con exito.");
                location.reload();
            }
        });
    });
    $('.editarAnimal').click(function(){
        var id = $(this).attr('id');
        var tipo = 'Editar';
        window.location.href = '/carepets/usuario/editar/editarAñadirAnimalAdopcion.php?tipo='+tipo+'&id='+id;
    });
});

function redireccionarAñadirAnimal() {
  var tipo = 'Añadir';
  window.location.href = '/carepets/usuario/editar/editarAñadirAnimalAdopcion.php?tipo='+tipo;
}
