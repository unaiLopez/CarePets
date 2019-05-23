//Borrar animal en adopcion clicado por id del animal
$(document).ready(function() {
 $("a #borrar").click(function() {
    var id = $(".container-fluid .animal-en-adopcion").attr('id');
    window.location.href = "/carepets/usuario/perfil/borrarAnimal.php?id=id";
    });
 });
});
