<?php
  $correoServicio = $_SESSION['id'];

  //Obtener todos los servicios que ofrece el usuario
  $sentencia = $conn->prepare("SELECT * FROM servicio WHERE mailusuario=:mailusuario");
  $sentencia->bindParam(':mailusuario', $correoServicio);
  $sentencia->execute();
  $servicios = $sentencia->fetchAll(PDO::FETCH_BOTH);

?>
