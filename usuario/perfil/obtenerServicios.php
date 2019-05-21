<?php
  $correoActual = $_SESSION['mail'];

  //Obtener todos los servicios que ofrece el usuario
  $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->execute();
  $servicios = $sentencia->fetchAll(PDO::FETCH_BOTH);

?>
