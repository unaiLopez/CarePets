<?php
  try {
    //Variables para buscar en la BD
    $correoActual = $_SESSION['mail'];
    $id = $_SESSION['id'];
    $leido = 1;
    $tipoMensaje = 'Mensaje';
    $tipoSolicitud = 'Solicitud';

    //Buscar el mensaje
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id and tipo=:tipo1 or tipo=:tipo2");
    $sentencia->bindParam(':id', $id);
    $sentencia->bindParam(':tipo1', $tipoMensaje);
    $sentencia->bindParam(':tipo2', $tipoSolicitud);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_ASSOC);

    if($mensaje['mailemisor'] == $correoActual){

      $leidoemisor = 1;
      $sql = "UPDATE mensaje SET leidoemisor=? WHERE id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$leidoemisor, $id]);

    }else if($mensaje['mailreceptor'] == $correoActual){

      $leidoreceptor = 1;
      $sql = "UPDATE mensaje SET leidoreceptor=? WHERE id=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$leidoreceptor, $id]);

    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
