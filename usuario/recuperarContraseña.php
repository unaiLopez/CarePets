<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  /* Exception class. */
  require_once '..\PHPMailer\src\Exception.php';

  /* The main PHPMailer class. */
  require_once '..\PHPMailer\src\PHPMailer.php';

  /* SMTP class, needed if you want to use SMTP. */
  require_once '..\PHPMailer\src\SMTP.php';

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

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->IsHTML(true);
    $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Mailer = "smtp";
    $mail->Host = gethostbyname('smtp.gmail.com'); // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'ssl'; // ssl is depracated
    $mail->SMTPAuth = true;
    $mail->Username = "cuidacarepets@gmail.com";
    $mail->Password = "Aixerrota1";
    $mail->SetFrom('cuidacarepets@gmail.com', 'CarePets');
    $mail->AddAddress($address);
    $mail->Subject = $subject;
    $mail->MsgHTML($message); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
    $mail->AltBody = 'HTML messaging not supported';

    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
        echo false;
    }else{
        echo "Message sent!";
        echo true;
    }

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
