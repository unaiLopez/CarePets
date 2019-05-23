<?php
  $correoActual = $_SESSION['mail'];

  //Tomar todos los datos de todos los animales en adopcion del usuario
  $sentencia = $conn->prepare("SELECT * FROM animal WHERE mailusuario=:mailusuario ORDER BY fecha ASC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->execute();
  $animales = $sentencia->fetchAll(PDO::FETCH_BOTH);

?>
