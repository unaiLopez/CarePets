<?php
  try {
    //Variables para buscar en la BD
    $correoActual = $_SESSION['mail'];
    $noLeido = 0;
    $tipoMensaje = 'Mensaje';

    //Mensajes enviados con respuesta sin leer
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailemisor=:mailusuario and leidoemisor=:no and tipo=:tipo");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':no', $noLeido);
    $sentencia->bindParam(':tipo', $tipoMensaje);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $notificacionesEnviados = count($filas);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
