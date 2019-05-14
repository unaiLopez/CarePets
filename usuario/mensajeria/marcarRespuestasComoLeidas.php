<?php
  try {
    //Variables para buscar en la BD
    $correoActual = $_SESSION['mail'];
    $id = $_SESSION['id'];
    $leido = 1;
    $tipo = 'Respuesta';

    //Buscar todos los mensajes que sean de tipo respuesta de este mismo mensaje y que sean respuestas del receptor
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE idrespuesta=:id and tipo=:tipo and mailemisor not in (:mailreceptor)");
    $sentencia->bindParam(':id', $id);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':mailreceptor', $correoActual);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    //Se marcaran como leidos todas las respuestas de este mensaje por haber entrado dentro del mensaje principal
    foreach ($filas as $fila) {
      if($fila['leido'] == 0){
        $idmensajeactual = $fila['id'];
        $sql = "UPDATE mensaje SET leido=? WHERE id=?";
        $sentencia= $conn->prepare($sql);
        $sentencia->execute([$leido, $idmensajeactual]);
      }
    }

    require_once '../datosUsuario.php';

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
