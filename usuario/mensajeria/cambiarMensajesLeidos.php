<?php
  try {
    //Variables para buscar en la BD
    $noLeido = 0;
    $tipo = 'Respuesta';

    //Buscar todos los mensajes que sean de tipo respuesta
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo and leidoreceptor=:no");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':no', $noLeido);
    $sentencia->execute();
    $filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    //Todos los mensajes que tengan respuestas sin leer se convertiran en mensajes no leidos
    foreach ($filas as $fila) {
      if($fila['leidoreceptor'] == 0){
        $idMensajeCambiar = $fila['idrespuesta'];
        $sql = "UPDATE mensaje SET leidoreceptor=? WHERE id=?";
        $sentencia= $conn->prepare($sql);
        $sentencia->execute([$noLeido, $idMensajeCambiar]);
      }
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
