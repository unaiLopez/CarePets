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
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);

    //Conseguir datos del mensaje
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);

    $mailreceptor = $mensaje['mailemisor'];
    $receptor = $mensaje['emisor'];
    $emisor = $mensaje['receptor'];

    if($mensaje['mailemisor'] == $correoActual){
      $leidoemisor = 1;
      $leidoreceptor = 0;
    }else if($mensaje['mailreceptor'] == $correoActual){
      $leidoemisor = 0;
      $leidoreceptor = 1;
    }

    //Insertar mensaje de respuesta
    $sentencia = $conn->prepare("INSERT INTO mensaje (tipo,contenido,fecha,mailemisor,mailreceptor,emisor,receptor,idrespuesta) VALUES(:tipo,:contenido,:fecha, :mailemisor,:mailreceptor,:emisor,:receptor,:idrespuesta)");
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':contenido', $contenido);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':mailemisor', $correoActual);
    $sentencia->bindParam(':mailreceptor', $mailreceptor);
    $sentencia->bindParam(':emisor', $emisor);
    $sentencia->bindParam(':receptor', $receptor);
    $sentencia->bindParam(':idrespuesta', $id);
    $sentencia->execute();

    $sql = "UPDATE mensaje SET leidoemisor=?, leidoreceptor=? WHERE id=?";
    $sentencia= $conn->prepare($sql);
    $sentencia->execute([$leidoemisor,$leidoreceptor, $id]);

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
