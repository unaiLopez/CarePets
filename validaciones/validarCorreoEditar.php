<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
    $correo = $_POST['mail'];
    $resultado = false;

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->execute();
    $rows = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows && filter_var($correo, FILTER_VALIDATE_EMAIL) || $rows && $rows['user_id'] == $idActual){
      $resultado = true;
    }

    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
