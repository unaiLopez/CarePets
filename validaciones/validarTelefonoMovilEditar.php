<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
    $movil = $_POST['movil'];
    $resultado = false;

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE telefonomovil=:telefonomovil");
    $sentencia->bindParam(':telefonomovil', $movil);
    $sentencia->execute();
    $rows1 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla clinica
    $sentencia = $conn->prepare("SELECT * FROM clinica WHERE telefonofijo=:telefonomovil");
    $sentencia->bindParam(':telefonomovil', $movil);
    $sentencia->execute();
    $rows2 = $sentencia->fetch(PDO::FETCH_ASSOC);

    //Buscar en la tabla protectora
    $sentencia = $conn->prepare("SELECT * FROM protectora WHERE telefonofijo=:telefonomovil");
    $sentencia->bindParam(':telefonomovil', $movil);
    $sentencia->execute();
    $rows3 = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows1 && !$rows2 && !$rows3 && strlen((string)$movil) == 9 || $rows1 && $rows1['user_id'] == $idActual){
      $resultado = true;
    }

    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
