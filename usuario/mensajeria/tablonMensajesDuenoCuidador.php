<?php
  require_once '../../validaciones/verificarDuenoCuidador.php';

  try {

    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    //Variables para buscar en la BD
    $idActual = $_SESSION['user_id'];
    $noLeido = 0;
    $tipo1 = 'Mensaje';
    $tipo2 = 'Solicitud';
    $tipo3 = 'Respuesta';

    //Tomar todas las solicitudes que te han hecho y ponerlos en orden de fecha de más reciente a menos reciente
    $sentencia = $conn->prepare("SELECT * FROM mensaje m INNER JOIN solicitud s ON m.idrespuesta=s.id WHERE m.user_id_receptor=:user_id ORDER BY fecha DESC");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->execute();
    $solicitudes = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    //Se tomarán los mensajes enviados por mi de la base de datos
    require_once 'mensajesEnviados.php';
    //Se tomarán los mensajes enviados por el usuario que han sido respondidos y los mensajes que me han enviado otros cuidadores de la base de datos
    require_once 'mensajesRecibidos.php';
    //Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaRecibidosMensajes.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaRecibidosSolicitudes.php';
    //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaEnviados.php';
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
   <script src="../../js/mensajeriaDuenoCuidador.js"></script>
 </head>
<body>
  <div id="container">
    <!-- Navegación -->
    <nav class="navbar navbar-expand-md navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../perfil/perfilDuenoCuidador.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
        <div class="dropdown">
          <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">
            <?php
              if($row1['foto']){
                echo '<img src="'.$row1['foto'].'" class="imagen-de-perfil" height="70" width="70">';
              }else{
                echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-de-perfil" height="70" width="70">';
              }
             ?>
          </a>
          <ul class="dropdown-menu">
              <li><a href="../perfil/perfilDuenoCuidador.php"><i class="fas fa-user"></i> Perfil</a></li>
              <hr>
              <li><a href="../editar/editarDuenoCuidador.php"><i class="fas fa-user-edit"></i> Editar</a></li>
              <hr>
              <li><a href="tablonMensajesDuenoCuidador.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes+$notificacionesEnviados+$notificacionesRecibidosSolicitudes; ?></span></a></li>
              <hr>
              <li><a href="../busqueda/menuBusqueda.php"><i class="fas fa-search"></i> Búsqueda</a></li>
              <hr>
              <li><a href="../ayuda/elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
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
                   <a onclick="mostrarTabMensajesEnviados()" class="nav-link active" id="enviados-tab" data-toggle="tab" href="#enviados" role="tab" aria-controls="enviados" aria-selected="true">Enviados <span class="badge badge-primary badge-pill"><?php echo $notificacionesEnviados; ?></span></a>
                  </li>
                  <li class="nav-item">
                   <a onclick="mostrarTabMensajesRecibidos()" class="nav-link" id="recibidos-tab" data-toggle="tab" href="#recibidos" role="tab" aria-controls="recibidos" aria-selected="true">Recibidos <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes; ?></span></a>
                  </li>
                  <li class="nav-item">
                    <a onclick="mostrarTabSolicitudes()" class="nav-link" id="solicitudes-tab" data-toggle="tab" href="#solicitudes" role="tab" aria-controls="solicitudes" aria-selected="false">Solicitudes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosSolicitudes; ?></span></a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-12 scroll">
                <div style="height: 350px;" class="card-body mx-auto">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="enviados" role="tabpanel" aria-labelledby="enviados-tab">
                      <div id="mensajesEnviados">
                        <?php
                          foreach ($mensajesEnviados as $mensajeEnviado){
                            $emisor = $mensajeEnviado['emisor'];
                            $asunto = $mensajeEnviado['asunto'];
                            $fecha = $mensajeEnviado['fecha'];
                            $id = $mensajeEnviado['id'];
                            if($mensajeEnviado['user_id_emisor'] == $idActual && $mensajeEnviado['leidoemisor'] == 1){
                              echo '<ul class="list-group list-group-horizontal">
                                      <div class="row">
                                        <li id="'.$id.'" class="list-group-item">'.$emisor.'</li>
                                        <li id="'.$id.'" class="list-group-item">'.$asunto.'</li>
                                        <li id="'.$id.'" class="list-group-item">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                      </div>
                                    </ul>';
                            }else if($mensajeEnviado['user_id_emisor'] == $idActual && $mensajeEnviado['leidoemisor'] == 0){
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
                          <br>
                          <br>
                      </div>
                    </div>
                    <div class="tab-pane fade show active" id="recibidos" role="tabpanel" aria-labelledby="recibidos-tab">
                      <div id="mensajesRecibidos">
                        <?php
                          foreach ($mensajesRecibidos as $mensajeRecibido){
                            $emisor = $mensajeRecibido['emisor'];
                            $asunto = $mensajeRecibido['asunto'];
                            $fecha = $mensajeRecibido['fecha'];
                            $id = $mensajeRecibido['id'];
                            if($mensajeRecibido['user_id_receptor'] == $idActual && $mensajeRecibido['leidoreceptor'] == 1){
                              echo '<ul class="list-group list-group-horizontal">
                                      <div class="row">
                                        <li id="'.$id.'" class="list-group-item">'.$emisor.'</li>
                                        <li id="'.$id.'" class="list-group-item">'.$asunto.'</li>
                                        <li id="'.$id.'" class="list-group-item">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                      </div>
                                    </ul>';
                            }else if($mensajeRecibido['user_id_receptor'] == $idActual && $mensajeRecibido['leidoreceptor'] == 0){
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
                        <br>
                        <br>
                    </div>
                    <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">
                      <div class="solicitudes">
                        <?php
                          foreach ($mensajesRecibidosSolicitudes as $mensajeRecibidoSolicitud){
                            $emisor = $mensajeRecibidoSolicitud['emisor'];
                            $asunto = $mensajeRecibidoSolicitud['asunto'];
                            $fecha = $mensajeRecibidoSolicitud['fecha'];
                            $id = $mensajeRecibidoSolicitud['id'];
                            if($mensajeRecibidoSolicitud['leidoreceptor'] == 1){
                              echo '<ul class="list-group list-group-horizontal">
                                      <div class="row">
                                        <li id="'.$id.'" class="list-group-item">'.$emisor.'</li>
                                        <li id="'.$id.'" class="list-group-item">'.$asunto.'</li>
                                        <li id="'.$id.'" class="list-group-item">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                      </div>
                                    </ul>';
                            }else{
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
                         <br>
                         <br>
                      </div>
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
              <a href="https://www.facebook.com/unai.lopez5851"><i class="fab fa-facebook-square"></i></a>
              <a href="https://www.instagram.com/carepets1/"><i class="fab fa-instagram"></i></a>
              <a href="https://twitter.com/cuidacarepets"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
