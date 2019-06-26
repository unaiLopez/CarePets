<?php
  $tipoMensaje = 'Mensaje';

  //Tomar todos los mensajes directos recibidos
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':tipo', $tipoMensaje);
  $sentencia->execute();
  $mensajesRecibidos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

  //Tomar todos los mensajes recibidos
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE tipo=:tipo and mailreceptor=:mailusuario ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':tipo', $tipoMensaje);
  $sentencia->execute();
  $mensajesRecibidos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
