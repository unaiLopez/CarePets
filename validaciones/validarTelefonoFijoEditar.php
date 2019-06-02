<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $fijo = $_POST['fijo'];
    $resultado = false;

    //Buscar en la tabla clinica
    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE telefonofijo=:telefonofijo");
    $sentencia->bindParam(':telefonofijo', $fijo);
    $sentencia->execute();
    $rows1 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE telefonomovil=:telefonofijo");
    $sentencia->bindParam(':telefonofijo', $fijo);
    $sentencia->execute();
    $rows2 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla protectora
    $sentencia = $conn->prepare("SELECT * FROM protectora WHERE telefonofijo=:telefonofijo");
    $sentencia->bindParam(':telefonofijo', $fijo);
    $sentencia->execute();
    $rows3 = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows1 && !$rows2 && !$rows3 && strlen((string)$fijo) == 9 || $rows3 && $rows3['mailusuario'] == $correoActual){
      $resultado = true;
    }

    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
