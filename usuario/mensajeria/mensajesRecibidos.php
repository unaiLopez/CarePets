<?php
  $tipoMensaje = 'Mensaje';
  $tipoSolicitud = 'Solicitud';

  //Tomar todos los mensajes directos recibidos
  $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':tipo', $tipoMensaje);
  $sentencia->execute();
  $mensajesRecibidos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

  //Tomar todas las solicitudes recibidas
  $sentencia = $conn->prepare("SELECT * FROM mensaje m INNER JOIN solicitud s ON m.idrespuesta=s.id WHERE m.tipo=:tipo and m.mailreceptor=:mailusuario ORDER BY fecha DESC");
  $sentencia->bindParam(':mailusuario', $correoActual);
  $sentencia->bindParam(':tipo', $tipoSolicitud);
  $sentencia->execute();
  $mensajesRecibidosSolicitudes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
