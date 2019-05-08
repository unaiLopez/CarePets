<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    include '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $id = $_GET['id'];
    $tipo = 'Respuesta';
    $contenido = $_POST['respuesta'];
    $leido = 0;
    $mailemisor = $correoActual;
    //Tomar fecha y hora actual
    $tz_object = new DateTimeZone('Europe/Madrid');
    //date_default_timezone_set('Brazil/East');

    $fecha = new DateTime();
    $fecha->setTimezone($tz_object);
    $fecha->format('Y\-m\-d\ h:i:s');

    //Conseguir el mail del mailreceptor
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);
    $mailreceptor = $mensaje['mailemisor'];

    //Borrar mensaje seleccionado
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,contenido,fecha,leido,mailemisor,mailreceptor,idrespuesta) VALUES(:tipo,:contenido,:fecha,:leido,:mailemisor,:mailreceptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':leido', $leido);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $correoActual);
    $sentencia->bindParam(':idrespuesta', $id);
    $sentencia->execute();

    header('Location: mostrarMensaje.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
