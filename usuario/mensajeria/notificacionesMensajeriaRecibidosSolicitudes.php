<?php
  try {
    //Variables para buscar en la BD
    $idActual = $_SESSION['user_id'];
    $noLeido = 0;
    $tipo = 'Solicitud';

    //Solicitudes recibidas sin leer
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE user_id_receptor=:user_id_receptor and tipo=:tipo and leidoreceptor=:no");
    $sentencia->bindParam(':user_id_receptor', $idActual);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':no', $noLeido);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $notificacionesRecibidosSolicitudes = count($filas);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
