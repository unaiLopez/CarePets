<?php
  $id = $_GET['id'];

  //Conseguir todas las respuestas del mensaje principal
  $sentencia = $conn->prepare("SELECT * FROM responder WHERE idmensajeprincipal=:id");
  $sentencia->bindParam(':id', $id);
  $sentencia->execute();
  $respuestas = $sentencia->fetchAll(PDO::FETCH_BOTH);

  foreach($respuestas as $respuesta){
    $idRespuesta = $respuesta['idmensajerespuesta'];
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $idRespuesta);
    $sentencia->execute();
    $mensajesRespuesta = $sentencia->fetchAll(PDO::FETCH_BOTH);
  }
?>
