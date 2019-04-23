<?php
  @ob_start();
  session_start();

  try {
    //Configurar base de datos
    include '../usuario/conectarDB.php';

    $conn = conectarse();

    $correoActual = $_SESSION['mail'];
    $correo = $_POST['mail'];
    $resultado = false;

    //Buscar en la tabla usuario
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->execute();
    $rows = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(!$rows && filter_var($correo, FILTER_VALIDATE_EMAIL) || $rows && $rows['mailusuario'] == $correoActual){
      $resultado = true;
    }

    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
