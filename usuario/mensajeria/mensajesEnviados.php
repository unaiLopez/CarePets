<?php
  $tipoMensaje = 'Mensaje';
  //Tomar todos los mensajes enviados por el usuario y ponerlos en orden de fecha de más reciente a menos reciente
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailemisor=:mailusuario and tipo=:tipo ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':tipo', $tipoMensaje);
  $sentencia->execute();
  $mensajesEnviados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
