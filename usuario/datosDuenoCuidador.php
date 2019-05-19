<?php
  try {

    $correoActual = $_SESSION['mail'];

    //Tomar los datos de la clinica
    $sentencia = $conn->prepare("SELECT * FROM duenocuidador WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->execute();
    $rowDuenoCuidador = $sentencia->fetch(PDO::FETCH_BOTH);

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
 ?>
