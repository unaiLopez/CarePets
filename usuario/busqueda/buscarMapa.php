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
    //buscar datos de búsqueda
    require_once 'buscar.php';

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTC035_2c7HqTdiIGYdAYtJCLI0ye4coc&libraries=places"></script>
    <link rel="stylesheet" href="../../css/estiloDifuminadoScrollingFooter.css"/>
    <link rel="stylesheet" href="../../css/estiloMenuIngresado.css"/>
    <link rel="stylesheet" href="../../css/estiloPanelesMapas.css"/>
    <link rel="stylesheet" href="../../css/estiloFormularios.css"/>
    <link rel="stylesheet" href="../../css/bootstrap-datepicker.css"/>
    <script src="../../js/funcionesBusqueda.js"></script>
    <script src="../../js/bootstrap-datepicker.js"></script>
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
              <div class="col-xs-12 col-lg-12 panel">
                <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="buscarservicios-tab" role="tabpanel" aria-labelledby="buscarservicios-tab">
                      <div class="row">
                        <div class="col-xs-12 col-md-5 col-lg-5">
                          <ul class="list-group list-group-horizontal scroll">
                            <div class="row ">
                              <li id="1" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">Esto es un prueba</li>
                              <li id="2" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">dsadas</li>
                              <li id="3" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">sdasdasdas</li>
                              <li id="4" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">dsadsadas</li>
                              <li id="5" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">dsadsadsad</li>
                              <li id="6" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">Esto es un prueba</li>
                              <li id="7" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">dsadas</li>
                              <li id="8" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">sdasdasdas</li>
                              <li id="9" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">dsadsadas</li>
                              <li id="10" class="list-group-item" style="width: 100%;background-color: rgba(224, 82, 3, 0.1);color: white;border-color:white;">dsadsadsad</li>
                            </div>
                          </ul>';
                        </div>
                        <div class="col-xs-12 col-md-7 col-lg-7">
                          <div id="map">Cargando Mapa...</div>
                          <?php
                            $arrayLocations = array();
                            foreach($busqueda as $markerUsuario) {
                                $arrayMarker = array();
                                $arrayInfoMarker = array();
                                array_push($arrayMarker, $markerUsuario['direccion'], $markerUsuario['latitud'], $markerUsuario['longitud'], $markerUsuario['nombre'], $markerUsuario['foto'], $markerUsuario['telefonomovil'], $markerUsuario['mailusuario'], $markerUsuario['tipo']);
                                array_push($arrayLocations, $arrayMarker);
                            }
                          ?>
                          <script type="text/javascript">
                        		function initialise() {
                        			// create map object and apply properties
                        			var map = new google.maps.Map( document.getElementById( "map" ), {
                                zoom: 9,
                                center: new google.maps.LatLng(<?php echo $row1['latitud']; ?>, <?php echo $row1['longitud']; ?>),
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                              });

                        			// create map bounds object
                        			var bounds = new google.maps.LatLngBounds();
                        			// create array containing locations
                        			var locations = <?php echo json_encode($arrayLocations); ?>

                        			// loop through locations and add to map
                        			for ( var i = 0; i < locations.length; i++ )
                        			{
                        				// get current location
                        				var location = locations[ i ];

                        				// create map position
                        				var position = new google.maps.LatLng( location[ 1 ], location[ 2 ] );

                        				// add position to bounds
                        				bounds.extend( position );
                                var tipoUsuario = location[ 7 ];
                                if(tipoUsuario == 'DuenoCuidador'){
                                  var icon = {
                                      url: "../../iconos/tipos_usuario/icono_dueño_cuidador.jpg", // url
                                      scaledSize: new google.maps.Size(30, 30), // scaled size
                                      origin: new google.maps.Point(0,0), // origin
                                      anchor: new google.maps.Point(0, 0) // anchor
                                  };
                                  var marker = new google.maps.Marker({
                          					animation: google.maps.Animation.DROP
                          					, icon: icon
                          					, map: map
                          					, position: position
                          					, title: location[ 0 ]
                          				});
                                }else if(tipoUsuario == 'Clinica'){
                                  var icon = {
                                      url: "../../iconos/tipos_usuario/icono_clinica_veterinaria.png", // url
                                      scaledSize: new google.maps.Size(30, 30), // scaled size
                                      origin: new google.maps.Point(0,0), // origin
                                      anchor: new google.maps.Point(0, 0) // anchor
                                  };
                                  var marker = new google.maps.Marker({
                          					animation: google.maps.Animation.DROP
                          					, icon: icon
                          					, map: map
                          					, position: position
                          					, title: location[ 0 ]
                          				});
                                }else if(tipoUsuario == 'Protectora'){
                                  var icon = {
                                      url: "../../iconos/tipos_usuario/icono_protectora_animales.jpg", // url
                                      scaledSize: new google.maps.Size(30, 30), // scaled size
                                      origin: new google.maps.Point(0,0), // origin
                                      anchor: new google.maps.Point(0, 0) // anchor
                                  };
                                  var marker = new google.maps.Marker({
                          					animation: google.maps.Animation.DROP
                          					, icon: icon
                          					, map: map
                          					, position: position
                          					, title: location[ 0 ]
                          				});
                                }
                        				// create info window and add to marker (https://developers.google.com/maps/documentation/javascript/reference#InfoWindowOptions)
                        				google.maps.event.addListener( marker, 'click', (
                        					function( marker, i ) {
                        						return function() {
                                      var contentString = '<div id="iw-container">' +
                                                            '<div class="iw-title">'+locations[i][3]+'</div>' +
                                                            '<div class="iw-content">' +
                                                              '<img src="'+locations[i][4]+'" alt="PerfilUsuario" height="100" width="100">' +
                                                              '<div class="iw-subTitle">Dirección</div>' +
                                                              '<p style="color:black;font-style=crimson;">'+locations[i][0]+'</p>'+
                                                              '<div class="iw-subTitle">Teléfono Movil</div>' +
                                                              '<p style="color:black;font-style=crimson;">'+locations[i][5]+'</p>'+
                                                              '<div class="iw-subTitle">Correo Electrónico</div>' +
                                                              '<p style="color:black;font-style=crimson;">'+locations[i][6]+'</p>'+
                                                            '</div>' +
                                                            '<div class="iw-bottom-gradient"></div>' +
                                                          '</div>';
                                      var infowindow = new google.maps.InfoWindow({
                                        content: contentString
                                      });
                        							infowindow.open( map, marker );
                        						}
                        					}
                        				)( marker, i ) );
                        			};
                        			// fit map to bounds

                        		}
                        		// load map after page has finished loading
                        		function loadScript() {
                        			var script = document.createElement( "script" );
                        			script.type = "text/javascript";
                        			script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDTC035_2c7HqTdiIGYdAYtJCLI0ye4coc&libraries=places&callback=initialise"; // initialize method called using callback parameter
                        			document.body.appendChild( script );
                        		}
                        		window.onload = loadScript;
                        		</script>
                        </div>
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
