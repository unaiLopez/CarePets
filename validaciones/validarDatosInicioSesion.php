<?php
  try {
    //Configurar base de datos
    include '../usuario/conectarDB.php';

    $conn = conectarse();

    $resultado = false;
    //Variables para insertar en la base de datos
    $correo = $_POST['mail'];
    //Inicio de la encriptación
    $contraseña = $_POST['pass'];
    $hash = crypt($contraseña, $correo);
    //Fin de la encriptación

    //Tomar el valor de la contraseña y del mail
    $sentencia = $conn->prepare("SELECT contrasena FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->execute();
    $row = $sentencia->fetch(PDO::FETCH_BOTH);

    //Verificar si el usuario existe y si la contraseña es correta
    if($row){
      if($row[0] == $hash){
        $resultado = true;
      }
    }
    echo $resultado;

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
