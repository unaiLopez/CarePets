<?php
  require_once '../../validaciones/verificarDuenoCuidador.php';
  try {
    require_once '../conectarDB.php';
    $conn = conectarse();
    //Cuenta la cantidad de mensajes no leidos para mostrarlo en las notificaciones posteriormente
    require_once '../mensajeria/mensajesRecibidosNoLeidos.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/solicitudesRecibidasNoLeidas.php';
    //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
    require_once '../mensajeria/mensajesEnviadosNoLeidos.php';
    //Tomar los datos del usuario para utilizarlos de forma dinámica
    require_once '../datosUsuario.php';
    //Tomar los datos de la clinica para utilizarlos de forma dinámica
    require_once '../datosDuenoCuidador.php';

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
    <link rel="stylesheet" href="../../css/bootstrap-datepicker.css"/>
    <script src="../../js/funcionesBusqueda.js"></script>
    <script src="../../js/bootstrap-datepicker.js"></script>
    <script>
			$(function() {
			$('.dates #usr1').datepicker({
				'format': 'yyyy-mm-dd',
				'autoclose': true
			});
		});
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
                <li><a href="../mensajeria/tablonMensajesDuenoCuidador.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidos+$notificacionesSolicitudes+$notificacionesEnviados; ?></span></a></li>
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
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                   <a class="nav-link active" id="buscarservicios-tab" data-toggle="tab" href="#buscarservicios" role="tab" aria-controls="buscarservicios" aria-selected="true"><i class="fas fa-search-location"></i> Buscar Servicios</a>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-lg-12 scroll">
                <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="buscarservicios-tab" role="tabpanel" aria-labelledby="buscarservicios-tab">
                      <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <br>
                            <h3>Busco</h3>
                            <select class="form-control" id="buscarTipo" name="buscarTipo">
                              <option>Cuidador</option>
                              <option>Clinica Veterinaria</option>
                              <option>Protectora de Animales</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                          <div class="container">
                            <div id="tiposServicios"></div>
                          </div>
                        </div>
                        <div id="fechas"></div>
                        <div id="fecha"></div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                          <div class="container">
                            <br>
                            <h3>Desde</h3>
                            <div class="dates">
                              <input type="text" class="form-control" id="usr1" name="event_date" placeholder="Inicio" autocomplete="off" >
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                          <div class="container">
                            <br>
                            <h3>Hasta</h3>
                            <div class="dates">
                              <input type="text" class="form-control" id="usr1" name="event_date" placeholder="Final" autocomplete="off" >
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                          <div class="container">
                            <br>
                            <br>
                            <button style="margin-top: 16px" type="submit" id="submit" name="buscar" class="btn btn-default block"><i class="fas fa-search"></i> Buscar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div id="informacionServicios"></div>
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
