<?php
  try {
    //Configurar base de datos
    include 'conectarDB.php';

    $conn = conectarse();

    $correo = $_REQUEST['emailRecuperar'];

    $sentencia = $conn->prepare("SELECT contrasena FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->execute();
    $row = $sentencia->fetch(PDO::FETCH_BOTH);
    if($row){
      $contraseña = $row[0];
      $hash = crypt($contraseña, $correo);
      $to = $correo;
      $subject = "Nueva Contraseña";
      $message = "Esta es su nueva contraseña. Por favor, usela para iniciar sesión la próxima vez".$hash;
      $headers = "From: unai19970315@gmail.com"."\r\n";
      if(mail($to, $subject, $message, $headers)){
        mail($to, $subject, $message, $headers);
        echo "Tu nueva contraseña ha sido enviada a su dirección de correo electrónico.";
        header('Location: ingresar.html');
      }else{
        echo "No se ha podido recuperar su contraseña, vuelva a intentarlo.";
      }
    }
  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
