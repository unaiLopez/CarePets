<?php
  $idRespuesta = -1;

  //Tomar todos los mensajes enviados por el usuario y ponerlos en orden de fecha de más reciente a menos reciente
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailemisor=:mailusuario and idrespuesta=:id ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':id', $idRespuesta);
  $sentencia->execute();
  $mensajesEnviados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
