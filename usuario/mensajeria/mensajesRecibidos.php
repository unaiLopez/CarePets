<?php
  $tipoMensaje = 'Mensaje';
  $tipoSolicitud = 'Solicitud';

  //Tomar todos los mensajes directos recibidos
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE user_id_receptor=:user_id and tipo=:tipo ORDER BY fecha DESC");
  $sentencia->bindParam(':user_id', $idActual);
  $sentencia->bindParam(':tipo', $tipoMensaje);
  $sentencia->execute();
  $mensajesRecibidos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

  //Tomar todas las solicitudes recibidas
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE tipo=:tipo and user_id_receptor=:user_id ORDER BY fecha DESC");
  $sentencia->bindParam(':user_id', $idActual);
  $sentencia->bindParam(':tipo', $tipoSolicitud);
  $sentencia->execute();
  $mensajesRecibidosSolicitudes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
