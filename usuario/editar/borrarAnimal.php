<?php
  $correoActual = $_SESSION['mail'];
  $idAnimal = $_GET['id'];

  //Tomar la media de las valoraciones al usuario
  $sentencia = $conn->prepare("DELETE FROM animal WHERE id=:id and mailusuario=:mailusuario");
  $sentencia->bindParam(':id', $idAnimal);
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->execute();

  header('Location: mostrarEditarTablonAdopciones.php');
?>
