<?php
  require_once '../../validaciones/verificarDuenoCuidador.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
    $idActual = $_SESSION['user_id'];
    //Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/notificacionesMensajeriaRecibidosMensajes.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/notificacionesMensajeriaRecibidosSolicitudes.php';
    //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/notificacionesMensajeriaEnviados.php';
    //Tomar los datos del usuario para utilizarlos de forma dinámica
    require_once '../datosUsuario.php';
    //Tomar los datos de la clinica para utilizarlos de forma dinámica
    require_once '../datosDuenoCuidador.php';
    //Obtener el rating del datosUsuario
    require_once 'obtenerRating.php';
    //Obetener datos de los servicios que ofrece el datosUsuario
    require_once 'obtenerServicios.php';

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
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
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <link rel="stylesheet" href="../../css/starRating.css">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
      function convertirmeCuidador() {
        window.location.href = "../editar/editarDuenoCuidador.php";
      }
    </script>
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
                <li><a href="../mensajeria/tablonMensajesDuenoCuidador.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes+$notificacionesEnviados+$notificacionesRecibidosSolicitudes; ?></span></a></li>
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
                   <a class="nav-link active" id="miperfil-tab" data-toggle="tab" href="#miperfil" role="tab" aria-controls="miperfil" aria-selected="true"><i class="fas fa-user"></i> Mi Perfil</a>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-lg-12 scroll">
                <div style="height: 350px;" class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="miperfil-tab" role="tabpanel" aria-labelledby="miperfil-tab">
                      <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <?php
                              if($row1['foto']){
                                echo '<img src="'.$row1['foto'].'" class="imagen-de-perfil" height="240" width="200">';
                              }else{
                                echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg"  class="imagen-de-perfi" height="240" width="200">';
                              }
                             ?>
                          </div>
                        </div>
                        <?php if($rowDuenoCuidador['escuidador'] == 0){
                        echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">';
                          echo '<div class="container">';
                            echo '<br>';
                            echo '<h3>¡Hola '.$row1['nombre'].'!</h3>';
                            echo '<br>';
                            echo '<h5>Aún no eres cuidador</h5>';
                            echo '<h5>¿A qué esperas?</h5>';
                            echo '<br>';
                            echo '<button id="convertirmecuidador" onclick="convertirmeCuidador()" name="convertirmecuidador" class="btn btn-default"><i class="fas fa-paw"></i> Convertirme en Cuidador</button>';
                          echo '</div>';
                        echo '</div>';
                        }else{ ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <h3>¡Hola <?php echo $row1['nombre']; ?>!</h3>
                            <br>
                            <h5>Reputación como cuidador :</h5>
                            <x-star-rating value="<?=$mediaMostrar?>" number="5"></x-star-rating>
                            <br>
                            <label for="cantidadValoraciones">Con <?php echo $cantidadValoraciones;?> valoraciones</label>

                            <br>
                            <br>
                            <label for="correo">Correo Electrónico :</label>
                            <br>
                            <?php echo $row1['mailusuario']; ?>
                            <br>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <?php
                              if($row1['descripcion']){
                                echo '<label for="descripcion">Descripción :</label>';
                                echo '<br>';
                                echo $row1['descripcion'];
                                echo '<br>';
                                echo '<br>';
                              }
                              if($row1['direccion']){
                                echo '<label for="direccion">Dirección :</label>';
                                echo '<br>';
                                echo $row1['direccion'];
                                echo '<br>';
                              }
                            ?>
                            <br>
                            <label for="movil">Teléfono Móvil :</label>
                            <br>
                            <?php echo $row1['telefonomovil']; ?>
                            <br>
                            <br>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <?php
                              foreach($servicios as $servicio){
                                $nombre = $servicio['nombre'];
                                $precio = $servicio['precio'];
                                if($nombre == 'Alojamiento' && $precio != 0){
                                  echo '<span><img src="../../iconos/miscelanea/icono_noche.png" height="40" with="40">';
                                  echo ' '.$nombre.' '.$precio.' €';
                                  echo '<br>';
                                  echo '<br>';
                                }else if($nombre == 'Dia Entero' && $precio != 0){
                                  echo '<img src="../../iconos/miscelanea/icono_dia.png" height="40" with="40"> ';
                                  echo ' '.$nombre.' '.$precio.' €';
                                  echo '<br>';
                                  echo '<br>';
                                }else if($nombre == 'Paseo' && $precio != 0){
                                  echo '<img src="../../iconos/miscelanea/icono_paseo.png" height="40" with="40"> ';
                                  echo ' '.$nombre.' '.$precio.' €';
                                  echo '<br>';
                                  echo '<br>';
                                }else if($nombre == 'Visita' && $precio != 0){
                                  echo '<img src="../../iconos/miscelanea/icono_casa.png" height="40" with="40">';
                                  echo ' '.$nombre.' '.$precio.' €';
                                  echo '<br>';
                                  echo '<br>';
                                }
                              }
                            ?>
                          </div>
                        </div>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
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
<?php
  //Valora los servicios que ya hayas recibido
  require_once 'valorarServicio.php';
?>
<script src="../../js/showStars.js"></script>
