<?php
  try {

    $correoActual = $_SESSION['mail'];

    //Tomar los datos del usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $row1 = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
