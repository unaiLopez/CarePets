$(document).ready(function() {
    $('.borrarAnimal').click(function(){
        var id = $(this).attr('id');
        alert(id);
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
        alert(id);
        var data = {"id" : id};
        $.ajax({
            type: 'post',
            url: '/carepets/usuario/editar/editarAnimalAdopcion.php',
            data: data,
            async: false,
            success: function() {
                alert("El animal se ha editado con exito.");
            }
        });
    });
});
