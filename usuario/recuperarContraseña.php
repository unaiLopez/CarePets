<?php
  //Crear contraseña de 6 dígitos
  function crearNuevaContraseña(){
    $n = array(0,1,2,3,4,5,6,7,8,9);
    $nuevaContraseñaArray = array_rand($n, 6);
    return $nuevaContraseñaArray[0].$nuevaContraseñaArray[1].$nuevaContraseñaArray[2].$nuevaContraseñaArray[3].$nuevaContraseñaArray[4].$nuevaContraseñaArray[5];
  }

  try {
    //Configurar base de datos
    require_once 'conectarDB.php';

    $conn = conectarse();

    $correo = $_POST['mailusuario'];

    $nuevaContraseña = crearNuevaContraseña();

    $to = $correo;
    $subject = "Nueva Contraseña CarePets";
    $message = "Esta es su nueva contraseña. Por favor, usela para iniciar sesión la próxima vez: ".$nuevaContraseña;
    $headers = "From: cuidacarepets@gmail.com"."\r\n";
    if(mail($to, $subject, $message, $headers)){
      mail($to, $subject, $message, $headers);
      echo 'true';
    }else{
      echo 'false';
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
