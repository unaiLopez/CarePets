//En el perfil de inicio inicializa las pestaás (tabs)
function mostrarInfoInicio(){
  $('#tablonAdopciones').load("mostrarTablonAdopciones.php");
  $('#tablonAdopciones').hide();
  $('#perfilProtectora').load("mostrarPerfilProtectora.php");
}
//Muestra el tablon de adopciones y oculta el perfil
function mostrarTablon(){
  $('#tablonAdopciones').show();
  $('#perfilProtectora').hide();
}
//Muestra el perfil y oculta el tablon de adopciones
function mostrarPerfil(){
  $('#perfilProtectora').show();
  $('#tablonAdopciones').hide();
}
