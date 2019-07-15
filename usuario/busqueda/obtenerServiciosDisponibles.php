<?php
  $idUsuarioServicio = $_SESSION['idUsuarioServicio'];

  //Obtener todos los servicios que ofrece el usuario
  $sentencia = $conn->prepare("SELECT * FROM servicio WHERE user_id=:user_id");
  $sentencia->bindParam(':user_id', $idUsuarioServicio);
  $sentencia->execute();
  $servicios = $sentencia->fetchAll(PDO::FETCH_BOTH);

?>
