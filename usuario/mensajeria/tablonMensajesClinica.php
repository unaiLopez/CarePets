<?php
  require_once '../../validaciones/verificarClinica.php';

  try {

    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    //Variables para buscar en la BD
    $idActual = $_SESSION['user_id'];

    //Se tomarán los mensajes enviados por el usuario que han sido respondidos y los mensajes que me han enviado otros cuidadores de la base de datos
    require_once 'mensajesRecibidos.php';
    //Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaRecibidosMensajes.php';
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
    <script src="../../js/mensajeriaClinica.js"></script>
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
                  echo '<img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" class="imagen-perfil" height="70" width="70">';
                }
               ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="../perfil/perfilClinica.php"><i class="fas fa-user"></i> Perfil</a></li>
                <hr>
                <li><a href="../editar/editarClinica.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                <hr>
                <li><a href="tablonMensajesClinica.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes; ?></span></a></li>
                <hr>
                <li><a href="../../ayuda/elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
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
                   <a class="nav-link active" id="recibidos-tab" data-toggle="tab" href="#recibidos" role="tab" aria-controls="recibidos" aria-selected="true">Recibidos <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes; ?></span></a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-12 scroll">
                <div class="card-body mx-auto">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="recibidos" role="tabpanel" aria-labelledby="recibidos-tab">
                      <?php
                        foreach ($mensajesRecibidos as $mensaje){
                          $emisor = $mensaje['emisor'];
                          $asunto = $mensaje['asunto'];
                          $fecha = $mensaje['fecha'];
                          $id = $mensaje['id'];
                          if($mensaje['user_id_receptor'] == $idActual && $mensaje['leidoreceptor'] == 1){
                            echo '<ul class="list-group list-group-horizontal">
                                    <div class="row">
                                      <li id="'.$id.'" class="list-group-item">'.$emisor.'</li>
                                      <li id="'.$id.'" class="list-group-item">'.$asunto.'</li>
                                      <li id="'.$id.'" class="list-group-item">&nbsp;&nbsp;&nbsp; '.$fecha.'</li>
                                    </div>
                                  </ul>';
                          }else if($mensaje['user_id_receptor'] == $idActual && $mensaje['leidoreceptor'] == 0){
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
      </div>
    </div>
  </body>
</html>
