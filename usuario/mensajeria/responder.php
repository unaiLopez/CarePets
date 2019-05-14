<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $id = $_POST['idmensaje'];
    $tipo = 'Respuesta';
    $contenido = $_POST['respuesta'];
    $leido = 0;
    //Tomar fecha y hora actual
    $tz_object = new DateTimeZone('Europe/Madrid');
    //date_default_timezone_set('Brazil/East');

    $fecha = new DateTime();
    $fecha->setTimezone($tz_object);
    $fecha->format('Y\-m\-d\ h:i:s');

    //Conseguir el mail del receptor
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);
    $mailreceptor = $mensaje['mailemisor'];

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,contenido,fecha,leido,mailemisor,mailreceptor,idrespuesta) VALUES(:tipo,:contenido,:fecha,:leido,:mailemisor,:mailreceptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':leido', $leido);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $mailreceptor);
    $sentencia->bindParam(':idrespuesta', $id);
    $sentencia->execute();

    header('Location: mostrarMensaje.php?id='.$id);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
