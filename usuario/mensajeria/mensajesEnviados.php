<?php
  $tipoMensaje = 'Mensaje';
  $tipoSolicitud = 'Solicitud';
  //Tomar todos los mensajes enviados por el usuario y ponerlos en orden de fecha de más reciente a menos reciente
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailemisor=:mailusuario and tipo=:tipo1 or tipo=:tipo2 ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':tipo1', $tipoMensaje);
  $sentencia->bindParam(':tipo2', $tipoSolicitud);
  $sentencia->execute();
  $mensajesEnviados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
