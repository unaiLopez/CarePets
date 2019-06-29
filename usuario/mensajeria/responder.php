<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $id = $_POST['idmensaje'];
    $tipo = 'Respuesta';
    $contenido = $_POST['respuesta'];
    $leidoReceptor = 0;
    $leidoEmisor = 1;
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Conseguir el mail del receptor
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);
    $mailreceptor = $mensaje['mailemisor'];
    $receptor = $mensaje['emisor'];
    $emisor = $mensaje['receptor'];

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,contenido,fecha,leidoreceptor,leidoemisor,mailemisor,mailreceptor,emisor,receptor,idrespuesta) VALUES(:tipo,:contenido,:fecha,:leidoreceptor,:leidoemisor, :mailemisor,:mailreceptor,:emisor,:receptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':leidoreceptor', $leidoReceptor);
    $sentencia->bindParam(':leidoemisor', $leidoEmisor);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $mailreceptor);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':receptor', $receptor);
    $sentencia->bindParam(':idrespuesta', $id);
    $sentencia->execute();
    
    $_SESSION['id'] = $id;

    if($sentencia){
      echo true;
    }else{
      echo false;
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
