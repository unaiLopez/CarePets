<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $idActual = $_SESSION['user_id'];

    $nombre = $_POST['nombre'];
    $raza = $_POST['raza'];
    $peso = $_POST['peso'];
    $sexo = $_POST['sexo'];
    $edad = $_POST['edad'];
    $desparasitado = $_POST['desparasitado'];
    $amigable = $_POST['amigable'];
    $esterilizado = $_POST['esterilizado'];
    $vacunado = $_POST['vacunado'];
    $descripcion = $_POST['descripcion'];
    $fotoPerfil = $_FILES['avatar']['name'];
    //Tomar fecha y hora actual año-mes-dia hora:minuto:segundo
    $tiempo = time();
    $fecha = date("Y-m-d H:i:s", $tiempo);


    if(!empty($fotoPerfil)){
      //Se cuentan todas las imagenes de la carpeta para dar un id a la imagen y que no se repitan los nombres
      $nombreFoto = explode('.', $fotoPerfil);
      $pathCarpeta  = '../../iconos/fotos/fotos_adopcion/'.$idActual.'/';
      $totalImagenes = count(glob($pathCarpeta.'{*.jpg,*.gif,*.png}',GLOB_BRACE));
      $numeroImagen = $totalImagenes + 1;
      $fotoPerfil = $numeroImagen.'.'.$nombreFoto[1];
      for($i = 0; $i < 2 ; $i++){
        if(!mkdir($pathCarpeta, 0777)){
          $ruta = $_FILES['avatar']['tmp_name'];
          $destino = $pathCarpeta.$fotoPerfil;
          copy($ruta, $destino);
        }
      }

      //Insertar animal
      $sentencia = $conn->prepare("INSERT INTO animal(foto, fecha, nombre, raza, peso, desparasitado, amigable, esterilizado, vacunado, sexo, edad, descripcion, user_id) VALUES(:foto, :fecha, :nombre, :raza, :peso, :desparasitado, :amigable, :esterilizado, :vacunado, :sexo, :edad, :descripcion, :user_id)");
      $sentencia->bindParam(':foto', $destino);
      $sentencia->bindParam(':fecha', $fecha);
      $sentencia->bindParam(':nombre', $nombre);
      $sentencia->bindParam(':raza', $raza);
      $sentencia->bindParam(':peso', $peso);
      $sentencia->bindParam(':desparasitado', $desparasitado);
      $sentencia->bindParam(':amigable', $amigable);
      $sentencia->bindParam(':esterilizado', $esterilizado);
      $sentencia->bindParam(':vacunado', $vacunado);
      $sentencia->bindParam(':sexo', $sexo);
      $sentencia->bindParam(':edad', $edad);
      $sentencia->bindParam(':descripcion', $descripcion);
      $sentencia->bindParam(':user_id', $idActual);
      $sentencia->execute();

    }else{
      //Insertar en la tabla usuario
      $sentencia = $conn->prepare("INSERT INTO animal(fecha, nombre, raza, peso, desparasitado, amigable, esterilizado, vacunado, sexo, edad, descripcion, user_id) VALUES(:fecha, :nombre, :raza, :peso, :desparasitado, :amigable, :esterilizado, :vacunado, :sexo, :edad, :descripcion, :user_id)");
      $sentencia->bindParam(':fecha', $fecha);
      $sentencia->bindParam(':nombre', $nombre);
      $sentencia->bindParam(':raza', $raza);
      $sentencia->bindParam(':peso', $peso);
      $sentencia->bindParam(':desparasitado', $desparasitado);
      $sentencia->bindParam(':amigable', $amigable);
      $sentencia->bindParam(':esterilizado', $esterilizado);
      $sentencia->bindParam(':vacunado', $vacunado);
      $sentencia->bindParam(':sexo', $sexo);
      $sentencia->bindParam(':edad', $edad);
      $sentencia->bindParam(':descripcion', $descripcion);
      $sentencia->bindParam(':user_id', $idActual);
      $sentencia->execute();
    }

    header('Location: editarProtectora.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
