<?php
  try {
    //Variables para buscar en la BD
    $correoActual = $_SESSION['mail'];
    $noLeido = 0;
    $tipo = 'Mensaje';

    //Mensajes recibidos sin leer
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo and leidoreceptor=:no");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':no', $noLeido);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $notificacionesRecibidosMensajes = count($filas);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
