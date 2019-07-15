<?php
  $idActual = $_SESSION['user_id'];

  //Tomar todos los datos de todos los animales en adopcion del usuario
  $sentencia = $conn->prepare("SELECT * FROM animal WHERE user_id=:user_id ORDER BY fecha ASC");
  $sentencia->bindParam(':user_id', $idActual);
  $sentencia->execute();
  $animales = $sentencia->fetchAll(PDO::FETCH_BOTH);

?>
