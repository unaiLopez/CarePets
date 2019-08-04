<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../PHPMailer/src/Exception.php';
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';

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

    $nuevaContraseña = crearNuevaContraseña();

    $correo = $_POST['mailusuario'];

    $address = $correo;
    $subject = "Nueva Contraseña CarePets";
    $message = "Esta es su nueva contraseña. Por favor, usela para iniciar sesión la próxima vez: ".$nuevaContraseña;

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 4;
    $mail->SMTPSecure = 'tls'; // ssl is depracated
    $mail->Host = 'smtp.gmail.com'; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = '587'; // TLS only
    $mail->isHTML();
    $mail->Username = "cuidacarepets@gmail.com";
    $mail->Password = "Aixerrota1";
    $mail->SetFrom('no-reply@cuidacarepets.com');
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($correo);

    if($mail->Send()){
      echo true;
    }else{
      echo false;
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
