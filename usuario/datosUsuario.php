<?php
  try {

    $idActual = $_SESSION['user_id'];

    //Tomar los datos del usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->execute();
    $row1 = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
