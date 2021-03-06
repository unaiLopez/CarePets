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

    //Tomar los datos de la clinica
    $sentencia = $conn->prepare("SELECT tipo FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correo);
    $sentencia->execute();
    $miUsuario = $sentencia->fetch(PDO::FETCH_BOTH);

    if($miUsuario){

      $hash = crypt($nuevaContraseña, $miUsuario[0]);

      $sql = "UPDATE usuario SET contrasena=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$hash, $correo]);

      if($sentencia){

        $address = $correo;
        $subject = "Nueva Contraseña CarePets";
        $message = "Esta es su nueva contraseña. Por favor, usela para iniciar sesión la próxima vez: ".$nuevaContraseña;
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.ionos.es'; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->SMTPAuth = true;
        $mail->Username = "cuidacarepets@carepets.es";
        $mail->Password = "Aixerrota1#";
        $mail->SMTPSecure = 'tls'; // ssl is depracated
        $mail->Port = '587'; // TLS only
        $mail->isHTML();
        $mail->setFrom('cuidacarepets@carepets.es');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if($mail->send()){
          echo true;
        }else{
          echo false;
        }

      }
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }catch(Exception $e){
    echo 'No se pudo enviar el mensaje. Mailer Error: ', $mail->ErrorInfo;
  }
  $conn = null;
?>
