<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];

    //Conseguir el mail del receptor
    $sentencia = $conn->prepare("SELECT direccion,telefonomovil,nombre FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_BOTH);

    $tipo = 'Mensaje';
    $emisor = $usuario['nombre'];
    $leidoEmisor = 1;
    $leidoReceptor = 0;
    $mailReceptor = $_POST['mailUsuarioServicio'];
    $asunto = $_POST['asunto'];
    $contenido = $_POST['contenido'];
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Insertar mensaje de emisor
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,emisor,contenido,fecha,asunto,leidoemisor,leidoreceptor,mailemisor,mailreceptor) VALUES(:tipo,:emisor,:contenido,:fecha,:asunto,:leidoemisor,:leidoreceptor,:mailemisor,:mailreceptor)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':asunto', $asunto);
    $sentencia->bindParam(':leidoemisor', $leidoEmisor);
    $sentencia->bindParam(':leidoreceptor', $leidoReceptor);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $mailReceptor);
    $sentencia->execute();

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
