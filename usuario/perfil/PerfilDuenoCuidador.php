<?php
  require_once '../../validaciones/verificarDuenoCuidador.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
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
    <script src="https://cdnjs.cloudflare.com/ajax/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <link rel="stylesheet" href="../../css/starRating.css">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
                  echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="70" width="70">';
                }else{
                  echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-perfil" height="70" width="70">';
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
                   <a class="nav-link active" id="miperfil-tab" data-toggle="tab" href="#miperfil" role="tab" aria-controls="miperfil" aria-selected="true"><i class="fas fa-user"></i> Mi Perfil</a>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-lg-12 scroll">
                <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="miperfil-tab" role="tabpanel" aria-labelledby="miperfil-tab">
                      <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <?php
                              if($row1['foto']){
                                echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="240" width="200">';
                              }else{
                                echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-perfil" height="240" width="200">';
                              }
                             ?>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <h3>¡Hola <?php echo $row1['nombre']; ?>!</h3>
                            <?php
                              if($rowDuenoCuidador['escuidador'] == 0){
                                  echo '<br>';
                                  echo '<h5>Aún no eres cuidador</h5>';
                                  echo '<h5>¿A qué esperas?</h5>';
                                  echo '<button id="convertirmecuidador" onclick="javascript:window.location.href=../editar/editarDuenoCuidador.php#cuidador/" name="convertirmecuidador" class="btn btn-default"><i class="fas fa-paw"></i> Convertirme en Cuidador</button>';
                              }else{
                             ?>

                            <br>
                            <h5>Reputación como cuidador :</h5>
                            <x-star-rating value="<?=$mediaMostrar?>" number="5"></x-star-rating>
                            <br>
                            <label for="cantidadValoraciones">Con <?php echo $cantidadValoraciones;?> valoraciones</label>
                            <script src="../../js/showStars.js"></script>
                            <br>
                            <br>
                            <label for="movil">Teléfono Móvil :</label>
                            <br>
                            <?php echo $row1['telefonomovil']; ?>
                            <br>
                            <br>
                            <label for="correo">Correo Electrónico :</label>
                            <br>
                            <?php echo $row1['mailusuario']; ?>
                            <br>
                            <br>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <?php
                              if($rowDuenoCuidador['perro'] || $rowDuenoCuidador['gato'] || $rowDuenoCuidador['exotico'] || $rowDuenoCuidador['otros']) {
                                echo '<label for="animalesCuidas">Animales que cuidas :</label>';
                                echo '<br>';
                                if($rowDuenoCuidador['perro'] && $rowDuenoCuidador['gato'] && $rowDuenoCuidador['exotico'] && $rowDuenoCuidador['otros']) {
                                  echo 'Cuidas todo tipo de animales';
                                }else{
                                  if($rowDuenoCuidador['perro'])
                                    echo 'Perros';
                                    echo '<br>';
                                  if($rowDuenoCuidador['gato'])
                                    echo 'Gatos';
                                    echo '<br>';
                                  if($rowDuenoCuidador['exotico'])
                                    echo 'Animales exóticos';
                                    echo '<br>';
                                  if($rowDuenoCuidador['otros'])
                                    echo 'Otros animales';
                                }
                                echo '<br>';
                              }
                              if($rowDuenoCuidador['pequeno'] || $rowDuenoCuidador['mediano'] || $rowDuenoCuidador['grande']){
                                echo '<label for="tamañosCuidar">Tamaños que cuidas :</label>';
                                echo '<br>';
                                if($rowDuenoCuidador['pequeno']){
                                  echo '<span>Pequeños 1 - 5 kg  &nbsp;&nbsp; <img src="../../iconos/miscelanea/icono_perro.png" height="20" with="20"></span></label>';
                                  echo '<br>';
                                  echo '<br>';
                                }
                                if($rowDuenoCuidador['mediano']){
                                  echo '<span>Pequeños 5 - 15 kg  &nbsp;&nbsp; <img src="../../iconos/miscelanea/icono_perro.png" height="25" with="25"></span></label>';
                                  echo '<br>';
                                  echo '<br>';
                                }
                                if($rowDuenoCuidador['grande']){
                                  echo '<span>Pequeños 15 - 50 kg  &nbsp;&nbsp; <img src="../../iconos/miscelanea/icono_perro.png" height="30" with="30"></span></label>';
                                  echo '<br>';
                                  echo '<br>';
                                }
                                if($rowDuenoCuidador['experiencia']){
                                  echo '<br>';
                                  echo '<label for="experiencia">Experiencia :</label>';
                                  echo '<br>';
                                  echo $rowDuenoCuidador['experiencia'].' Años';
                                  echo '<br>';
                                }
                              }
                            ?>
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
                <a href="www.facebook.com"><i class="fab fa-facebook-square"></i></a>
                <a href="www.instagram.com"><i class="fab fa-instagram"></i></a>
                <a href="www.twitter.com"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
