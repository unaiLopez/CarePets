<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];
    $tipo = $_SESSION['verificar'];
    //Encriptar la contraseña para poder buscarla en la BD
    $pass = $_POST['pass'];
    $hash = crypt($pass, $tipo);
    //Fin de la encriptación

    $resultado = false;

    //Buscar en la tabla usuario la contraseña actual
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id and contrasena=:contrasena");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->bindParam(':contrasena', $hash);
    $sentencia->execute();
    $row = $sentencia->fetch(PDO::FETCH_BOTH);

    if($row){
        $resultado = true;
    }

    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
