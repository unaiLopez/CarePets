<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    include '../usuario/conectarDB.php';

    $conn = conectarse();

    $mail = $_SESSION['mail'];
    //Encriptar la contraseña para poder buscarla en la BD
    $pass = $_POST['pass'];
    $hash = crypt($pass, $mail);
    //Fin de la encriptación

    $resultado = false;

    //Buscar en la tabla usuario la contraseña actual
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE mailusuario=:mailusuario and contrasena=:contrasena");
    $sentencia->bindParam(':mailusuario', $mail);
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
