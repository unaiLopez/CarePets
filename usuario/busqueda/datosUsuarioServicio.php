<?php

    $correoServicio = $_SESSION['id'];

    //Tomar el tipo de usuario
    $sentencia = $conn->prepare("SELECT tipo FROM usuario WHERE mailusuario=:mailusuario");
    $sentencia->bindParam(':mailusuario', $correoServicio);
    $sentencia->execute();
    $rowTipo = $sentencia->fetch(PDO::FETCH_BOTH);

    if($rowTipo[0] == 'DuenoCuidador'){
      //Tomar datos desde la tabla usuario y de duenocuidador
      $sentencia = $conn->prepare("SELECT * FROM usuario AS u NATURAL JOIN duenocuidador AS d WHERE mailusuario=:mailusuario");
      $sentencia->bindParam(':mailusuario', $correoServicio);
      $sentencia->execute();
      $row1 = $sentencia->fetch(PDO::FETCH_BOTH);

    }else if($rowTipo[0] == 'Clinica'){
      //Tomar datos desde la tabla usuario y de clinica
      $sentencia = $conn->prepare("SELECT * FROM usuario AS u NATURAL JOIN clinica AS c WHERE mailusuario=:mailusuario");
      $sentencia->bindParam(':mailusuario', $correoServicio);
      $sentencia->execute();
      $row1 = $sentencia->fetch(PDO::FETCH_BOTH);

    }else if($rowTipo[0] == 'Protectora'){
      //Tomar datos desde la tabla usuario y de protectora
      $sentencia = $conn->prepare("SELECT * FROM usuario AS u NATURAL JOIN protectora AS p WHERE mailusuario=:mailusuario");
      $sentencia->bindParam(':mailusuario', $correoServicio);
      $sentencia->execute();
      $row1 = $sentencia->fetch(PDO::FETCH_BOTH);

    }

 ?>
