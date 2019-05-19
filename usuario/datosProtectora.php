<?php
  try {

    $correoActual = $_SESSION['mail'];

    //Tomar los datos de la clinica
    $sentencia = $conn->prepare("SELECT * FROM protectora WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $rowProtectora = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
