<?php
  $correoActual = $_SESSION['mail'];

  //Tomar todos los datos de todos los animales en adopcion del usuario
  $sentencia = $conn->prepare("SELECT foto,tipoimagen FROM usuario WHERE mailusuario=:mailusuario");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->execute();
  $usuarioFoto = $sentencia->fetch(PDO::FETCH_BOTH);

  $avatar = $usuarioFoto['foto']; // Datos binarios de la imagen.
  $tipo = $usuarioFoto['tipoimagen'];  // Mime Type de la imagen.
  // Mandamos las cabeceras al navegador indicando el tipo de datos que vamos a enviar.
  $header = 'content-type'.$tipo;
  header($header);
  // A continuación enviamos el contenido binario de la imagen.
  echo $avatar;
?>
