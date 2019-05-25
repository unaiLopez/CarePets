$(document).ready(function() {
    $('.borrarAnimal').click(function(){
        var id = $(this).attr('id');
        alert(id);
        var data = {"id" : id};
        $.ajax({
            type: "POST",
            url: "/carepets/usuario/editar/borrarAnimalAdopcion.php",
            data: data,
            async: false,
            success: function() {
                alert("El animal se ha borrado con exito.");
            }
        });
    });
});
