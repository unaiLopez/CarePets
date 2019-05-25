<?php
  @ob_start();
  session_start();
  $correoActual = $_SESSION['mail'];
  $idAnimal = $_POST['id'];

  //Se elimina el animal con el id seleccionado
  $sentencia = $conn->prepare("DELETE FROM animal WHERE id=:id and mailusuario=:mailusuario");
  $sentencia->bindParam(':id', $idAnimal);
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->execute();
?>
