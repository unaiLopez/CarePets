<?php
  @ob_start();
  session_start();

  if(isset($_SESSION['mail'])){
    //Configurar base de datos
    require_once '../usuario/conectarDB.php';

    $conn = conectarse();

    require_once '../usuario/datosUsuario.php';
    //Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../usuario/mensajeria/notificacionesMensajeriaRecibidosMensajes.php';
    if($row1['tipo'] == 'Protectora'){
      //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
      require_once '../usuario/mensajeria/notificacionesMensajeriaRecibidosSolicitudes.php';
    }else if($row1['tipo'] == 'DuenoCuidador'){
      //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
      require_once '../usuario/mensajeria/notificacionesMensajeriaRecibidosSolicitudes.php';
      //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
      require_once '../usuario/mensajeria/notificacionesMensajeriaEnviados.php';
    }
  }
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/estiloDifuminado.css"/>
    <link rel="stylesheet" href="../css/estiloMenuIngresado.css"/>
  </head>
  <body>
    <div id="container">
      <!-- Navegación -->
      <?php
        if(!isset($_SESSION['mail'])){
          echo '<nav class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="../index.html"><img src="../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="../index.html"><p class="letra_nav"><i class="fas fa-home"></i> Inicio</p></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="elegirAyuda.php"><p class="letra_nav"><i class="fas fa-question"></i> Ayuda</p></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../registro/prerregistro.html"><p class="letra_nav"><i class="fas fa-user-plus"></i> Registrar</p></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../usuario/ingresar.html"><p class="letra_nav"><i class="fas fa-sign-in-alt"></i> Ingresar</p></a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>';
        }else{
          if($row1['tipo'] == 'DuenoCuidador'){
            $notificacionDuenoCuidador =  $notificacionesRecibidosMensajes+$notificacionesEnviados+$notificacionesRecibidosSolicitudes;
            echo '  <nav class="navbar navbar-expand-md navbar-light">
                <div class="container-fluid">
                  <a class="navbar-brand" href="../usuario/perfil/perfilDuenoCuidador.php"><img src="../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
                  <div class="dropdown">
                    <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">';
                      if($row1['foto']){
                        echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                      }else{
                        echo '<img src="../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-perfil" height="70" width="70">';
                      }
                    echo '</a>
                    <ul class="dropdown-menu">
                        <li><a href="../usuario/perfil/perfilDuenoCuidador.php"><i class="fas fa-user"></i> Perfil</a></li>
                        <hr>
                        <li><a href="../usuario/editar/editarDuenoCuidador.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                        <hr>
                        <li><a href="../usuario/mensajeria/tablonMensajesDuenoCuidador.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill">'.$notificacionDuenoCuidador.'</span></a></li>
                        <hr>
                        <li><a href="../usuario/busqueda/menuBusqueda.php"><i class="fas fa-search"></i> Búsqueda</a></li>
                        <hr>
                        <li><a href="#"><i class="fas fa-question"></i> Ayuda</a></li>
                        <hr>
                        <li><a href="../usuario/salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
                    </ul>
                  </div>
                </div>
              </nav>';
          }else if($row1['tipo'] == 'Protectora'){
            $notificacionProtectora = $notificacionesRecibidosMensajes+$notificacionesRecibidosSolicitudes;
            echo '  <nav class="navbar navbar-expand-md navbar-light">
                <div class="container-fluid">
                  <a class="navbar-brand" href="../usuario/perfil/perfilProtectora.php"><img src="../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
                  <div class="dropdown">
                    <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">';
                      if($row1['foto']){
                        echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                      }else{
                        echo '<img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" class="imagen-perfil" height="70" width="70">';
                      }
                    echo '</a>
                    <ul class="dropdown-menu">
                        <li><a href="../usuario/perfil/perfilProtectorar.php"><i class="fas fa-user"></i> Perfil</a></li>
                        <hr>
                        <li><a href="../usuario/editar/editarProtectora.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                        <hr>
                        <li><a href="../usuario/mensajeria/tablonMensajesProtectora.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"> '.$notificacionProtectora.'</span></a></li>
                        <hr>
                        <li><a href="elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
                        <hr>
                        <li><a href="../usuario/salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
                    </ul>
                  </div>
                </div>
              </nav>';
          }else if($row1['tipo'] == 'Clinica'){
            echo '  <nav class="navbar navbar-expand-md navbar-light">
                <div class="container-fluid">
                  <a class="navbar-brand" href="../usuario/perfil/perfilClinica.php"><img src="../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
                  <div class="dropdown">
                    <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">';
                      if($row1['foto']){
                        echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                      }else{
                        echo '<img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" class="imagen-perfil" height="70" width="70">';
                      }
                    echo '</a>
                    <ul class="dropdown-menu">
                        <li><a href="../usuario/perfil/perfilClinica.php"><i class="fas fa-user"></i> Perfil</a></li>
                        <hr>
                        <li><a href="../usuario/editar/editarClinica.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                        <hr>
                        <li><a href="../usuario/mensajeria/tablonMensajesClinica.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill">'.$notificacionesRecibidosMensajes.'</span></a></li>
                        <hr>
                        <li><a href="elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
                        <hr>
                        <li><a href="../usuario/salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
                    </ul>
                  </div>
                </div>
              </nav>';
          }

        }
      ?>
      <br>
      <div id="body">
        <div class="container-fluid padding">
          <br>
          <div class="row">
            <div class="col-xs-12 col-sm-12 offset-md-3 col-md-6 offset-lg-3 col-lg-6">
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/_5mTcyprbDk" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>
            </div>
          </div>
          <br>
          <div style="background-color: rgba(224, 82, 3, 0.6);border: solid 1px #ffffff;" class="card">
            <div style="background-color:#e05203;" class="card-header">
              <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                <li class="nav-item">
                 <a class="nav-link active" id="tiposusuario-tab" data-toggle="tab" href="#tiposusuario" role="tab" aria-controls="tiposusuario" aria-selected="true"><i class="fas fa-user"></i> Tipos de Usuario</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="container">
                  <br>
                  <img src="../iconos/tipos_usuario/icono_clinica_veterinaria.png" style="height:60px;width:60px;border-radius:360px;">
                  <label for="clinica"> Clinicas Veterinarias</label>
                  <p>Busca las clinicas veterinarias más cercanas y contáctalas mediante la mensajería</p>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="container">
                  <br>
                  <img src="../iconos/tipos_usuario/icono_dueño_cuidador.jpg" style="height:60px;width:60px;border-radius:360px;">
                  <label for="protectora"> Dueño y/o Cuidador</label>
                  <p>Busca las protectoras de animales más cercanas, contáctalas mediante la mensajería o solicita adoptarles algún animal desde su tablon de animales en adopción</p>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="container">
                  <br>
                  <img src="../iconos/tipos_usuario/icono_protectora_animales.jpg" style="height:60px;width:60px;border-radius:360px;">
                  <label for="protectora"> Protectoras de Animales</label>
                  <p>Busca alguien que cuide de tus mascotas y si lo deseas puedes cuidar las mascotas de otros usuarios para sacar un dinero extra</p>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div style="background-color: rgba(224, 82, 3, 0.6);border: solid 1px #ffffff;" class="card">
            <div style="background-color:#e05203;" class="card-header">
              <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                <li class="nav-item">
                 <a class="nav-link active" id="servicios-tab" data-toggle="tab" href="#servicios" role="tab" aria-controls="servicios" aria-selected="true"><i class="fas fa-paw"></i> Tipos de Servicio</a>
                </li>
              </ul>
            </div>
            <br>
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="container">
                  <br>
                  <img src="../iconos/miscelanea/icono_noche.png" height="40" with="40">
                  <label for="alojamiento"> Alojamiento</label>
                  <p>Deja a tu mascota alojada en la casa de tu cuidador para que la cuide las noches que necesites</p>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="container">
                  <br>
                  <img src="../iconos/miscelanea/icono_dia.png" height="40" with="40">
                  <label for="cuidadoDia"> Cuidado de Día</label>
                  <p>Deja a tu mascota en la casa de un cuidador para que la cuide durante el día</p>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="container">
                  <br>
                  <img src="../iconos/miscelanea/icono_paseo.png" height="40" with="40">
                  <label for="paseo"> Paseo</label>
                  <p>Un cuidador pasará a por tu mascota para darle un paseo de aproximadamente 1 hora</p>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="container">
                  <br>
                  <img src="../iconos/miscelanea/icono_casa.png" height="40" with="40">
                  <label for="visita"> Visita a Domicilio</label>
                  <p>Un cuidador pasará por tu casa para alimentar a tu mascota y darle los cuidados necesarios durante aproximadamente 1 hora</p>
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <div id="footer">
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
