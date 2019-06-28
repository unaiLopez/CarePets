<?php
  try {

    $idMensaje = $_SESSION['id'];

    //Tomar el mensaje solamente si es de tipo solicitud
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE id=:id");
    $sentencia->bindParam(':id', $idMensaje);
    $sentencia->execute();
    $solicitud = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>