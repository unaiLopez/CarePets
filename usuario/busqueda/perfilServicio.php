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
    require_once 'datosUsuarioServicio.php';
    //Obtener el rating del datosUsuario
    require_once 'obtenerRatingServicio.php';

    if($rowTipo[0] == 'DuenoCuidador'){
      //Obetener datos de los servicios cuando el tipo de usuario es dueno cuidador
      require_once 'obtenerServiciosDisponibles.php';
    }

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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPaneles.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <link rel="stylesheet" href="../../css/starRating.css">
    <link rel="stylesheet" href="../../css/estiloPanelesHorizontales.css"/>
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
    <script src="../../js/funcionesBusqueda.js"></script>
    <script src="../../js/mensajesDeAlerta.js"></script>
    <script src="../../js/pestañasConURL.js"></script>
    <script src="../../js/funcionesAnimalesAdopcion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
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
                    <a onclick="mostrarTabPerfil()" class="nav-link active block" id="perfil-tab" data-toggle="tab" href="#perfil" role="tab" aria-controls="perfil" aria-selected="true">
                      <?php if($row1['tipo']!='DuenoCuidador'){?>
                          <i class="fas fa-user"></i> Perfil de <strong><?php echo $row1['nombre'].' '; ?></strong>
                      <?php }else{ ?>
                        <i class="fas fa-user"></i> Perfil de <strong><?php echo $row1['nombre'].' '; ?></strong>| Servicio: <strong><?php echo $_SESSION['servicio']; ?></strong> | <?php if($_SESSION['servicio'] == 'Alojamiento'){?>Fechas: <strong>Desde <?php echo $_SESSION['fechaInicio']; ?> Hasta <?php echo $_SESSION['fechaFin']; ?></strong> <?php }else{ ?> Día:<strong> <?php echo $_SESSION['fechaDia']?></strong><?php } ?>
                      <?php } ?>
                    </a>
                  </li>
                  <?php if($row1['tipo'] == 'Protectora'){ ?>
                  <li class="nav-item">
                   <a onclick="mostrarTabTablonAdopciones()" class="nav-link" id="tablonadopciones-tab" data-toggle="tab" href="#tablonadopciones" role="tab" aria-controls="tablonadopciones" aria-selected="true"><i class="fas fa-paw"></i> Solicitar Adopción de Animal</a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
              <div class="col-xs-12 col-lg-12 scroll">
                <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="perfil-tab" role="tabpanel" aria-labelledby="perfil-tab">
                      <div id="perfil">
                        <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="container">
                              <br>
                              <?php
                                if($row1['foto']){
                                  echo '<img src="'.$row1['foto'].'" class="imagen-perfil" height="200" width="200">';
                                }else{
                                  echo '<img src="../../iconos/tipos_usuario/icono_dueño_cuidador.jpg" class="imagen-perfil" height="200" width="200">';
                                }
                               ?>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="container">
                              <br>
                              <h3>¡Hola <?php echo $row1['nombre']; ?>!</h3>
                              <br>
                              <h5>Reputación como cuidador :</h5>
                              <x-star-rating value="<?=$mediaMostrar?>" number="5"></x-star-rating>
                              <br>
                              <label for="cantidadValoraciones">Con <?php echo $cantidadValoraciones;?> valoraciones</label>
                              <script src="../../js/showStars.js"></script>
                              <br>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="container">
                              <br>
                              <?php
                                if($rowTipo['tipo'] != 'Protectora'){
                                  if($row1['experiencia']){
                                    echo '<label for="experiencia">Experiencia :</label>';
                                    echo '<br>';
                                    echo $row1['experiencia'].' Años';
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
                                  echo '<br>';
                                }
                              ?>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="container">
                              <br>
                              <label for="correo">Correo Electrónico :</label>
                              <br>
                              <?php echo $row1['mailusuario']; ?>
                              <br>
                              <br>
                              <label for="movil">Teléfono Móvil :</label>
                              <br>
                              <?php echo $row1['telefonomovil']; ?>
                              <br>
                              <br>
                            </div>
                          </div>
                        </div>
                        <div style="margin-top:15px;" class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <button onclick="volverBusqueda()" class="btn btn-default block"><i class="fas fa-arrow-alt-circle-left"></i> Volver a la Búsqueda</button>
                            <br>
                            <br>
                          </div>
                          <?php if($row1['tipo'] == 'DuenoCuidador'){ ?>
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <button onclick="solicitarServicio('<?php echo $row1['mailusuario']; ?>', '<?php echo $row1['nombre']; ?>', '<?php echo $_SESSION['servicio']; ?>', <?php echo $_SESSION['precio']; ?>, '<?php echo $_SESSION['fechaInicio']; ?>', '<?php echo $_SESSION['fechaFin']; ?>', '<?php echo $_SESSION['fechaDia']; ?>')" class="btn btn-default block"><i class="fas fa-handshake"></i> Solicitar Servicio</button>
                            <br>
                            <br>
                          </div>
                          <?php } ?>
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <button data-toggle="modal" href="#myModal" class="btn btn-default block"><i class="fas fa-envelope"></i> Enviar Mensaje</button>
                            <br>
                            <br>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="tablonAdopciones">
                      <?php if($row1['tipo'] == 'Protectora'){ ?>
                      <div class="tab-pane fade" id="tablonadopciones" role="tabpanel" aria-labelledby="tablonadopciones-tab">
                        <?php
                          require_once 'mostrarAdopcionDeAnimales.php';
                        ?>
                      </div>
                    <?php } ?>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4>Mensaje para: <?php echo $row1['nombre'];?></h4><span><button type="button" class="close" data-dismiss="modal">&times;</button></span>
                      </div>
                      <div style="height:325px;" id="recuperarMailModal" class="modal-body">
                        <div class="row">
                          <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mx-auto">
                            <div id="form-modal" class="form-group">
                              <div class="form-group">
                                <input class="form-control" id="asunto" name="asunto" placeholder="Asunto" required></input>
                              </div>
                              <div class="form-group">
                                <textarea class="form-control" col="12" rows="6" id="mensaje" name="mensaje" placeholder="Contenido del mensaje" required></textarea>
                              </div>
                              <div class="form-group">
                                <input type="hidden" id="mailusuarioservicio" name="mailusuarioservicio" value="<?=$row1['mailusuario']; ?>">
                              </div>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mx-auto">
                              <div id="form-modal" class="form-group">
                                <button onclick="enviarMensaje($('#mailusuarioservicio').val(), $('#asunto').val(), $('#mensaje').val())" name="enviar" id="enviar" class="btn btn-default block"><i class="far fa-comments"></i> Enviar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div style="height:90px;" class="modal-footer">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
                          <div id="form-modal" class="form-group">
                            <button class="btn btn-default block" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar Mensaje</button>
                          </div>
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
