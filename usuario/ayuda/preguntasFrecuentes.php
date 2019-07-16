<?php
  @ob_start();
  session_start();

  if(isset($_SESSION['user_id'])){
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

    require_once '../datosUsuario.php';
    //Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/notificacionesMensajeriaRecibidosMensajes.php';
    if($row1['tipo'] == 'Protectora'){
      //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
      require_once '../mensajeria/notificacionesMensajeriaRecibidosSolicitudes.php';
    }else if($row1['tipo'] == 'DuenoCuidador'){
      //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
      require_once '../mensajeria/notificacionesMensajeriaRecibidosSolicitudes.php';
      //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
      require_once '../mensajeria/notificacionesMensajeriaEnviados.php';
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
    <script src="../../js/mostrarPreguntasFrecuentes.js"></script>
    <link rel="stylesheet" href="../../css/estiloDifuminado.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
  </head>
  <body>
    <div id="container">
      <!-- Navegación -->
      <?php
      if(!isset($_SESSION['user_id'])){
        echo '<nav class="navbar navbar-expand-md navbar-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="../../index.html"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
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
                  <a class="nav-link" href="../../registro/prerregistro.html"><p class="letra_nav"><i class="fas fa-user-plus"></i> Registrar</p></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../ingresar.html"><p class="letra_nav"><i class="fas fa-sign-in-alt"></i> Ingresar</p></a>
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
                <a class="navbar-brand" href="../perfil/perfilDuenoCuidador.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
                <div class="dropdown">
                  <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">';
                    if($row1['foto']){
                      echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                    }else{
                      echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-perfil" height="70" width="70">';
                    }
                  echo '</a>
                  <ul class="dropdown-menu">
                      <li><a href="../perfil/perfilDuenoCuidador.php"><i class="fas fa-user"></i> Perfil</a></li>
                      <hr>
                      <li><a href="../editar/editarDuenoCuidador.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                      <hr>
                      <li><a href="../mensajeria/tablonMensajesDuenoCuidador.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill">'.$notificacionDuenoCuidador.'</span></a></li>
                      <hr>
                      <li><a href="../busqueda/menuBusqueda.php"><i class="fas fa-search"></i> Búsqueda</a></li>
                      <hr>
                      <li><a href="#"><i class="fas fa-question"></i> Ayuda</a></li>
                      <hr>
                      <li><a href="../salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
                  </ul>
                </div>
              </div>
            </nav>';
        }else if($row1['tipo'] == 'Protectora'){
          $notificacionProtectora = $notificacionesRecibidosMensajes+$notificacionesRecibidosSolicitudes;
          echo '  <nav class="navbar navbar-expand-md navbar-light">
              <div class="container-fluid">
                <a class="navbar-brand" href="../perfil/perfilProtectora.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
                <div class="dropdown">
                  <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">';
                    if($row1['foto']){
                      echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                    }else{
                      echo '<img src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" class="imagen-perfil" height="70" width="70">';
                    }
                  echo '</a>
                  <ul class="dropdown-menu">
                      <li><a href="../perfil/perfilProtectora.php"><i class="fas fa-user"></i> Perfil</a></li>
                      <hr>
                      <li><a href="../editar/editarProtectora.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                      <hr>
                      <li><a href="../mensajeria/tablonMensajesProtectora.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill">'.$notificacionProtectora.'</span></a></li>
                      <hr>
                      <li><a href="elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
                      <hr>
                      <li><a href="../salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
                  </ul>
                </div>
              </div>
            </nav>';
        }else if($row1['tipo'] == 'Clinica'){
          echo '  <nav class="navbar navbar-expand-md navbar-light">
              <div class="container-fluid">
                <a class="navbar-brand" href="../../usuario/perfil/perfilClinica.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
                <div class="dropdown">
                  <a href="#" class="btn btn-tertiary dropdown-toggle" data-toggle="dropdown">';
                    if($row1['foto']){
                      echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                    }else{
                      echo '<img src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" class="imagen-perfil" height="70" width="70">';
                    }
                  echo '</a>
                  <ul class="dropdown-menu">
                      <li><a href="../perfil/perfilClinica.php"><i class="fas fa-user"></i> Perfil</a></li>
                      <hr>
                      <li><a href="../editar/editarClinica.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                      <hr>
                      <li><a href="../mensajeria/tablonMensajesClinica.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill">'.$notificacionesRecibidosMensajes.'</span></a></li>
                      <hr>
                      <li><a href="elegirAyuda.php"><i class="fas fa-question"></i> Ayuda</a></li>
                      <hr>
                      <li><a href="../salir.php"><i class="fas fa-door-open"></i> Salir</a></li>
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
          <!-- Preguntas Frecuentes Dueó y/o Cuidador -->
          <div style="background-color: rgba(224, 82, 3, 0.6);border: solid 1px #ffffff;" class="card">
            <div style="background-color:#e05203;" class="card-header">
              <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                <li class="nav-item">
                 <a class="nav-link active" id="preguntasduenocuidador-tab" data-toggle="tab" href="#preguntasduenocuidador" role="tab" aria-controls="preguntasduenocuidador" aria-selected="true"><img class="logo_preguntas" src="../../iconos/miscelanea/preguntas_frecuentes.png" height="22" width="22"><img class="logo_preguntas" src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" height="30" width="30"> Preguntas Dueño y/o Cuidador</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta1">¿Cómo puedo convertirme en cuidador?</h5>
                  <div id="respuesta1">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Editar" o en "Perfil".</p>
                    <p><strong>3.</strong> Si has clicado en "Perfil", clica el botón "Convertirme en Cuidador".</p>
                    <p><strong>4.</strong> Ambas opciones te llevarán al panel de "Editar".</p>
                    <p><strong>5.</strong> Una vez ahí, clica la pestaña "Información Cuidador" y rellena el formulario.</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta2">¿Cómo puedo enviar mensajes?</h5>
                  <div id="respuesta2">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2.</strong> Haz clic en "Búsqueda".</p>
                    <p><strong>3.</strong> Rellena el formulario con los servicios que deseas buscar.</p>
                    <p><strong>4.</strong> Una vez rellenado, clica en el botón "Buscar".</p>
                    <p><strong>5.</strong> Verás una lista de usuarios con un mapa con sus ubicaciones.</p>
                    <p><strong>6.</strong> Clica en el usuario que más te convenga para entrar en su perfil.</p>
                    <p><strong>7.</strong> Una vez dentro de su perfil, clica en el botón "Enviar Mensaje".</p>
                  </div>
                  <br>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta3">¿Cómo puedo responder mensajes?</h5>
                  <div id="respuesta3">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Mensajería".</p>
                    <p><strong>3.</strong> En el panel de "Mensajería" verás múltiples pestañas.</p>
                    <p><strong>4.</strong> Clica en la pestaña que desees ver.</p>
                    <p><strong>5.</strong> Clica el mensaje que desees responder.</p>
                    <p><strong>6.</strong> Una vez dentro del mensaje, abajo del todo del panel clica el botón "Responder".</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta4">¿Cómo puedo cambiar mi contraseña?</h5>
                  <div id="respuesta4">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Editar".</p>
                    <p><strong>3.</strong> Dentro del panel "Editar", estarás en la pestaña "Cambiar Contraseña".</p>
                    <p><strong>4.</strong> Pon la contraseña que desees y clica el botón "Confirmar Cambios".</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta5">¿Cómo puedo solicitar servicios?</h5>
                  <div id="respuesta5">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2.</strong> Haz clic en "Búsqueda".</p>
                    <p><strong>3.</strong> Rellena el formulario con los servicios que deseas buscar.</p>
                    <p><strong>4.</strong> Una vez rellenado, clica en el botón "Buscar".</p>
                    <p><strong>5.</strong> Verás una lista de usuarios con un mapa con sus ubicaciones.</p>
                    <p><strong>6.</strong> Clica en el usuario que más te convenga para entrar en su perfil.</p>
                    <p><strong>7.</strong> Una vez dentro de su perfil, clica en el botón "Solicitar Servicio".</p>
                    <p><strong>8.</strong> Se le enviará un mensaje automáticamente al usuario solicitando el servicio.</p>
                    <p><strong>9.</strong> Este te lo aceptará, te lo rechazará o si está inactivo no obtendrás respuesta.</p>
                  </div>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>
          <!-- Preguntas Frecuentes Clínica Veterinaria -->
          <div style="background-color: rgba(224, 82, 3, 0.6);border: solid 1px #ffffff;" class="card">
            <div style="background-color:#e05203;" class="card-header">
              <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                <li class="nav-item">
                 <a class="nav-link active" id="preguntasclinica-tab" data-toggle="tab" href="#preguntasclinica" role="tab" aria-controls="preguntasclinica" aria-selected="true"><img class="logo_preguntas" src="../../iconos/miscelanea/preguntas_frecuentes.png" height="22" width="22"><img class="logo_preguntas" src="../../iconos/tipos_usuario/icono_clinica_veterinaria.png" height="30" width="30"> Preguntas Clínica Veterinaria</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta6">¿Cómo puedo enviar mensajes?</h5>
                  <div id="respuesta6">
                    <p><strong>1.</strong> Las clínicas veterinarias no pueden enviar mensajes.</p>
                    <p><strong>2.</strong> Esta es una medida tomada por CarePets para evitar el spam.</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta7">¿Cómo puedo solicitar servicios?</h5>
                  <div id="respuesta7">
                    <p><strong>1.</strong> Las clínicas veterinarias no pueden solicitar servicios.</p>
                  </div>
                  <br>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta8">¿Cómo puedo responder mensajes?</h5>
                  <div id="respuesta8">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Mensajería".</p>
                    <p><strong>3.</strong> En el panel de "Mensajería" verás múltiples pestañas.</p>
                    <p><strong>4.</strong> Clica en la pestaña que desees ver.</p>
                    <p><strong>5.</strong> Clica el mensaje que desees responder.</p>
                    <p><strong>6.</strong> Una vez dentro del mensaje, abajo del todo del panel clica el botón "Responder".</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta9">¿Cómo puedo cambiar mi contraseña?</h5>
                  <div id="respuesta9">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Editar".</p>
                    <p><strong>3.</strong> Dentro del panel "Editar", estarás en la pestaña "Cambiar Contraseña".</p>
                    <p><strong>4.</strong> Pon la contraseña que desees y clica el botón "Confirmar Cambios".</p>
                  </div>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>
          <!-- Preguntas Frecuentes Protectora de Animales -->
          <div style="background-color: rgba(224, 82, 3, 0.6);border: solid 1px #ffffff;" class="card">
            <div style="background-color:#e05203;" class="card-header">
              <ul class="nav nav-tabs card-header-tabs"  id="myTab" role="tablist">
                <li class="nav-item">
                 <a class="nav-link active" id="preguntasprotectora-tab" data-toggle="tab" href="#preguntasprotectora" role="tab" aria-controls="preguntasprotectora" aria-selected="true"><img class="logo_preguntas" src="../../iconos/miscelanea/preguntas_frecuentes.png" height="22" width="22"><img class="logo_preguntas" src="../../iconos/tipos_usuario/icono_protectora_animales.jpg" height="30" width="30"> Preguntas Protectoras de Animales</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta10">¿Cómo puedo enviar mensajes?</h5>
                  <div id="respuesta10">
                    <p><strong>1.</strong> Las protectoras de animales no pueden enviar mensajes.</p>
                    <p><strong>2.</strong> Esta es una medida tomada por CarePets para evitar el spam.</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta11">¿Cómo puedo solicitar servicios?</h5>
                  <div id="respuesta11">
                    <p><strong>1.</strong> Las clínicas veterinarias no pueden solicitar servicios.</p>
                  </div>
                  <br>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta12">¿Cómo puedo responder mensajes?</h5>
                  <div id="respuesta12">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Mensajería".</p>
                    <p><strong>3.</strong> En el panel de "Mensajería" verás múltiples pestañas.</p>
                    <p><strong>4.</strong> Clica en la pestaña que desees ver.</p>
                    <p><strong>5.</strong> Clica el mensaje que desees responder.</p>
                    <p><strong>6.</strong> Una vez dentro del mensaje, abajo del todo del panel clica el botón "Responder".</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta13">¿Cómo puedo cambiar mi contraseña?</h5>
                  <div id="respuesta13">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Editar".</p>
                    <p><strong>3.</strong> Dentro del panel "Editar", estarás en la pestaña "Cambiar Contraseña".</p>
                    <p><strong>4.</strong> Pon la contraseña que desees y clica el botón "Confirmar Cambios".</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta14">¿Cómo puedo añadir un animal a mi tablón de adopciones?</h5>
                  <div id="respuesta14">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Editar".</p>
                    <p><strong>3.</strong> Dentro del panel "Editar", estarás en la pestaña "Tablón de Adopciones".</p>
                    <p><strong>4.</strong> Dentro de esta pestaña, encontrarás arriba a la izquierda el botón "Añadir Animal". Clícalo.</p>
                    <p><strong>5.</strong> Serás redireccionado a otra página con un formulario.</p>
                    <p><strong>6.</strong> Rellénalo y clica el botón "Añadir Animal" en la parte inferior del formulario.</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta15">¿Cómo puedo editar un animal de mi tablón de adopciones?</h5>
                  <div id="respuesta15">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Editar".</p>
                    <p><strong>3.</strong> Dentro del panel "Editar", clica en la pestaña "Tablón de Adopciones".</p>
                    <p><strong>4.</strong> Dentro de esta pestaña, encontrarás un símbolo de un cuaderno y un lápiz dentro de cada subtabla.</p>
                    <p><strong>5.</strong> Si clicas ese símbolo serás redireccionado a otra página con un formulario.</p>
                    <p><strong>6.</strong> Rellénalo y clica el botón "Confirmar Cambios" en la parte inferior del formulario.</p>
                  </div>
                  <br>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 offset-md-1 col-md-5 offset-lg-1 col-lg-5">
                <div class="container">
                  <br>
                  <h5 class="pregunta" id="pregunta16">¿Cómo acepto una solicitud de adopción?</h5>
                  <div id="respuesta16">
                    <p><strong>1.</strong> Haz clic en el menú de arriba a la derecha.</p>
                    <p><strong>2</strong>. Haz clic en "Mensajería".</p>
                    <p><strong>3.</strong> Dentro del panel "Mensajería", clica la pestaña "Solicitudes".</p>
                    <p><strong>4.</strong> Dentro de esta pestaña, si tienes alguna solicitud te aparecerá.</p>
                    <p><strong>5.</strong> Clica la solicitud que desees revisar.</p>
                    <p><strong>6.</strong> Una vez dentro de dicha solicitud, encontrarás un dos botones: "Aceptar Solicitud" y "Rechazar Solicitud".</p>
                    <p><strong>7.</strong> Clica uno de los dos y se le enviará un mensaje automáticamente al solicitante con tu respuesta.</p>
                  </div>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <br>
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
