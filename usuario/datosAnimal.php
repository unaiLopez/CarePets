<?php
  $idAnimal = $_GET['id'];

  //Tomar todos los datos de todos los animales en adopcion del usuario
  $sentencia = $conn->prepare("SELECT * FROM animal WHERE id=:id");
  $sentencia->bindParam(':id', $idAnimal);
  $sentencia->execute();
  $animal = $sentencia->fetch(PDO::FETCH_BOTH);

?>
