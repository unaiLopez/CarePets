<?php
  try {

    $idActual = $_SESSION['user_id'];

    //Tomar los datos de la clinica
    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->execute();
    $rowClinica = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
