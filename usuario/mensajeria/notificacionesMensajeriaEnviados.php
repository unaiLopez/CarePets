<?php
  try {
    //Variables para buscar en la BD
    $idActual = $_SESSION['user_id'];
    $noLeido = 0;
    $tipoMensaje = 'Mensaje';

    //Mensajes enviados con respuesta sin leer
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE user_id_emisor=:user_id_emisor and leidoemisor=:no and tipo=:tipo");
    $sentencia->bindParam(':user_id_emisor', $idActual);
    $sentencia->bindParam(':no', $noLeido);
    $sentencia->bindParam(':tipo', $tipoMensaje);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $notificacionesEnviados = count($filas);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
