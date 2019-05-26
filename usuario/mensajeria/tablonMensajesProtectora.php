<?php
  require_once '../../validaciones/verificarProtectora.php';

  try {

    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    //Variables para buscar en la BD
    $correoActual = $_SESSION['mail'];
    $noLeido = 0;
    $tipo1 = 'Mensaje';
    $tipo2 = 'Solicitud';

    //Tomar todos los mensajes del usuario y ponerlos en orden de fecha de más reciente a menos reciente
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo ORDER BY fecha DESC");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':tipo', $tipo1);
    $sentencia->execute();
    $mensajes = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    //Tomar todas las solicitudes que te han hecho y ponerlos en orden de fecha de más reciente a menos reciente
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and tipo=:tipo ORDER BY fecha DESC");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':tipo', $tipo2);
    $sentencia->execute();
    $solicitudes = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    //Si un mensaje tiene respuestas sin leer. El mensaje principal se cambiará a no leido
    require_once 'cambiarMensajesLeidos.php';
    //Cuenta la cantidad de mensajes no leidos para mostrarlo en las notificaciones posteriormente
    require_once 'mensajesRecibidosNoLeidos.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once 'solicitudesRecibidasNoLeidas.php';
    //Toma los datos del usuario para mostrarlos posteriormente dinámicamente en la pantalla
    require_once '../datosUsuario.php';

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
 ?>


<!DOCTYPE html>

<html lang="es">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>CarePets</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/popper.js/1.12.9/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
   <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
   <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
   <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
   <script src="../../js/mensajeriaComun.js"></script>
   <script src="../../js/mensajeriaProtectora.js"></script>
   <script src="../../js/pestañasConURL.js"></script>
 </head>
<body>
  <div id="container">
    <!-- Navegación -->
    <nav class="navbar navbar-expand-md navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../perfil/perfilClinica.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
        <div class="dropdown">
          <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">
            <?php
              if($row1['foto']){
                echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
              }else{
                echo '<img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" class="imagen-perfil" height="70" width="70">';
              }
             ?>
          </a>
          <ul class="dropdown-menu">
              <li><a href="../perfil/perfilProtectora.php"><i class="fas fa-user"></i> Perfil</a></li>
              <hr>
              <li><a href="../editar/editarProtectora.php"><i class="fas fa-user-edit"></i> Editar</a></li>
              <hr>
              <li><a href="tablonMensajesProtectora.php"><i class="fas fa-envelope"></i> Mensajes  <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos+$notificacionesSolicitudes; ?></span></a></li>
              <hr>
              <li><a href="#"><i class="fas fa-users"></i> Foro</a></li>
              <hr>
              <li><a href="#"><i class="fas fa-question"></i> Ayuda</a></li>
              <hr>
              <li><a href="../salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <br>
      <div id="body">
        <div class="container-fluid">
          <div class="row">
            <div class="card">
              <div class="card-header mx-auto">
                <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                  <li class="nav-item">
                   <a class="nav-link active" id="recibidos-tab" data-toggle="tab" href="#recibidos" role="tab" aria-controls="recibidos" aria-selected="true">Recibidos <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos; ?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="solicitudes-tab" data-toggle="tab" href="#solicitudes" role="tab" aria-controls="solicitudes" aria-selected="false">Solicitudes <span class="badge badge-primary badge-pill"><?php echo $notificacionesSolicitudes; ?></span></a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-12 scroll">
                <div class="card-body mx-auto">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="recibidos" role="tabpanel" aria-labelledby="recibidos-tab">
                      <?php
                        foreach ($mensajes as $mensaje){
                          if($mensaje['mailreceptor'] == $correoActual && $mensaje['leido'] == 1){
                            $emisor = $mensaje['emisor'];
                            $asunto = $mensaje['asunto'];
                            $fecha = $mensaje['fecha'];
                            $id = $mensaje['id'];
                            echo '<ul class="list-group list-group-horizontal">
                                    <div class="row">
                                      <li id="'.$id.'" class="list-group-item">'.$emisor.'</li>
                                      <li id="'.$id.'" class="list-group-item">'.$asunto.'</li>
                                      <li id="'.$id.'" class="list-group-item">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                    </div>
                                  </ul>';
                          }else if($mensaje['mailreceptor'] == $correoActual && $mensaje['leido'] == 0){
                            $emisor = $mensaje['emisor'];
                            $asunto = $mensaje['asunto'];
                            $fecha = $mensaje['fecha'];
                            $id = $mensaje['id'];
                            echo '<ul class="list-group list-group-horizontal">
                                    <div class="row">
                                      <li id="'.$id.'" class="list-group-item" style="background-color: grey;color: white;border-color:white;">'.$emisor.'</li>
                                      <li id="'.$id.'" class="list-group-item" style="background-color: grey;color: white;border-color:white;">'.$asunto.'</li>
                                      <li id="'.$id.'" class="list-group-item" style="background-color: grey;color: white;border-color:white;">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                    </div>
                                  </ul>';
                          }
                         }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">
                      <?php
                        foreach ($solicitudes as $solicitud){
                          if($solicitud['leido'] == 1){
                            $emisor = $solicitud['emisor'];
                            $asunto = $solicitud['asunto'];
                            $fecha = $solicitud['fecha'];
                            $id = $solicitud['id'];
                            echo '<ul class="list-group list-group-horizontal">
                                    <div class="row">
                                      <li id="'.$id.'" class="list-group-item">'.$emisor.'</li>
                                      <li id="'.$id.'" class="list-group-item">'.$asunto.'</li>
                                      <li id="'.$id.'" class="list-group-item">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                    </div>
                                  </ul>';

                          }else{
                            $emisor = $solicitud['emisor'];
                            $asunto = $solicitud['asunto'];
                            $fecha = $solicitud['fecha'];
                            $id = $solicitud['id'];
                            echo '<ul class="list-group list-group-horizontal">
                                    <div class="row">
                                      <li id="'.$id.'" class="list-group-item" style="background-color: grey;color: white;border-color:white;">'.$emisor.'</li>
                                      <li id="'.$id.'" class="list-group-item" style="background-color: grey;color: white;border-color:white;">'.$asunto.'</li>
                                      <li id="'.$id.'" class="list-group-item" style="background-color: grey;color: white;border-color:white;">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                    </div>
                                  </ul>';
                          }
                        }
                       ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <!-- Footer -->
      <div class="footer">
        <div class="container-fluid padding">
          <div class="row text-center padding">
            <div class="col-lg-12 social padding">
              <a href="www.facebook.com"><i class="fab fa-facebook-square"></i></a>
              <a href="www.instagram.com"><i class="fab fa-instagram"></i></a>
              <a href="www.twitter.com"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
