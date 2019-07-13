<?php
  @ob_start();
  session_start();
  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    $mailActual = $_SESSION['mail'];

    $experiencia = $_POST['experiencia'];
    $especialidad = $_POST['especialidad'];
    $horario = $_POST['horario'];
    $descripcion = $_POST['descripcion'];
    $fotoPerfil = $_FILES['avatar']['name'];
    //Se cuentan todas las imagenes de la carpeta para dar un id a la imagen y que no se repitan los nombres
    $nombreFoto = explode('.', $fotoPerfil);
    $totalImagenes = count(glob('../../iconos/fotos/fotos_perfil/{*.jpg,*.gif,*.png}',GLOB_BRACE));
    $numeroImagen = $totalImagenes + 1;
    $fotoPerfil = $numeroImagen.'.'.$nombreFoto[1];
    //Fin de la conversión del nombre
    $ruta = $_FILES['avatar']['tmp_name'];
    $destino = "../../iconos/fotos/fotos_perfil/".$fotoPerfil;
    copy($ruta, $destino);

    if(!empty($fotoPerfil)){

      if (!isset($_FILES["avatar"]) || $_FILES["avatar"]["error"] > 0) {
        echo "Ha ocurrido un error.";
      }else{
        // Verificamos si el tipo de archivo es un tipo de imagen permitido.
        // y que el tamaño del archivo no exceda los 16MB
        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 16384;

        if (in_array($_FILES['avatar']['type'], $permitidos) && $_FILES['avatar']['size'] <= $limite_kb * 1024){
            // Archivo temporal
            $imagen_temporal = $_FILES['avatar']['tmp_name'];
            // Tipo de archivo
            $tipo = $_FILES['avatar']['type'];
            // Leemos el contenido del archivo temporal en binario.
            $fp = fopen($imagen_temporal, 'r+b');
            $data = fread($fp, filesize($imagen_temporal));
            fclose($fp);
            //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
            // $data=file_get_contents($imagen_temporal);
            // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
            $data = $conn->quote($data);

        }else{
            echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
        }

        $sql = "UPDATE usuario SET foto=?, tipoimagen=?, descripcion=? WHERE mailusuario=?";
        $sentencia= $conn->prepare($sql);
        $sentencia->execute([$data, $tipo, $descripcion, $mailActual]);

        $sql = "UPDATE clinica SET experiencia=?, especialidad=?, horario=? WHERE mailusuario=?";
        $sentencia= $conn->prepare($sql);
        $sentencia->execute([$experiencia, $especialidad, $horario, $mailActual]);
      }
    }else{
      $sql = "UPDATE usuario SET descripcion=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$descripcion, $mailActual]);

      $sql = "UPDATE clinica SET experiencia=?, especialidad=?, horario=? WHERE mailusuario=?";
      $sentencia= $conn->prepare($sql);
      $sentencia->execute([$experiencia, $especialidad, $horario, $mailActual]);
    }

    header('Location: editarClinica.php');

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
?>
