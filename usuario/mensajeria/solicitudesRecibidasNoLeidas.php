<?php
  try {
    //Variables para buscar en la BD
    $correoActual = $_SESSION['mail'];
    $noLeido = 0;
    $tipo = 'Solicitud';

    //Mensajes sin leer
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo and leidoreceptor=:no");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':no', $noLeido);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $notificacionesSolicitudes = count($filas);

    require_once '../datosUsuario.php';

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
?>
