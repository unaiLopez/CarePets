<?php
  try {

    $correoActual = $_SESSION['mail'];

    //Tomar los datos de la clinica
    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $rowClinica = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
