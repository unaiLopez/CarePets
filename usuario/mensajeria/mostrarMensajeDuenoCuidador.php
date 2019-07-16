<?php
	@ob_start();
	session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

		$id = $_SESSION['id'];

    //Tomar id del usuario
    $idActual = $_SESSION['user_id'];

    //Tomar los datos del mensaje
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE user_id_receptor=:user_id and id=:id");
    $sentencia->bindParam(':user_id', $idActual);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);
		if(!$mensaje){
			//Tomar los datos del mensaje
	    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE user_id_emisor=:user_id and id=:id");
	    $sentencia->bindParam(':user_id', $idActual);
	    $sentencia->bindParam(':id', $id);
	    $sentencia->execute();
	    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);
		}

		//Conseguir todas las respuestas del mensaje principal
		$sentencia = $conn->prepare("SELECT * FROM mensaje WHERE idrespuesta=:id ORDER BY fecha ASC");
		$sentencia->bindParam(':id', $id);
		$sentencia->execute();
		$respuestas = $sentencia->fetchAll(PDO::FETCH_BOTH);

		require_once 'actualizarMensajesLeidos.php';
		//Cuenta la cantidad de mensajes recibidos no leidos para mostrarlo en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaRecibidosMensajes.php';
    //Cuenta la cantidad de solicitudes no leidos para mostrarlos en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaRecibidosSolicitudes.php';
    //Cuenta la cantidad de mensajes enviados no leidos para mostrarlos en las notificaciones posteriormente
    require_once 'notificacionesMensajeriaEnviados.php';
    require_once '../datosUsuario.php';
		require_once 'datosMensaje.php';

		//Conseguir datos para contactar con el usuario que pide la solicitud
		if($mensaje['tipo'] == 'Solicitud'){
			if($solicitud){
				$sentencia = $conn->prepare("SELECT * FROM usuario WHERE user_id=:user_id");
				$sentencia->bindParam(':user_id', $mensaje['user_id_emisor']);
				$sentencia->execute();
				$datosUsuarioSolicitud = $sentencia->fetch(PDO::FETCH_BOTH);
			}
		}

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
		 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
   </head>
   <body>
     <div id="container">
       <!-- Navegación -->
       <nav class="navbar navbar-expand-md navbar-light">
         <div class="container-fluid">
           <a class="navbar-brand" href="../perfil/perfilProtectora.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
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
                 <li><a href="../perfil/perfilProtectora.php"><i class="fas fa-user"></i> Perfil</a></li>
                 <hr>
                 <li><a href="../editar/editarProtectora.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                 <hr>
                 <li><a href="../mensajeria/tablonMensajesProtectora.php"><i class="fas fa-envelope"></i> Mensajes <span class="badge badge-primary badge-pill"><?php echo $notificacionesRecibidosMensajes+$notificacionesEnviados+$notificacionesRecibidosSolicitudes; ?></span></a></li>
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
                    <a class="nav-link active" id="conversacion-tab" data-toggle="tab" href="#conversacion" role="tab" aria-controls="conversacion" aria-selected="true"><?php echo 'Conversación con : ';?><strong><?php if($idActual == $mensaje['user_id_receptor']){echo $mensaje['emisor'];}else{echo $mensaje['receptor'];}?></strong> </a>
                   </li>
                 </ul>
               </div>
               <div class="col-lg-12 scroll">
                 <div class="card-body mx-auto">
									 <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="conversacion" role="tabpanel" aria-labelledby="conversacion-tab">
											 <div class="mensaje">
												 <div class="row">
													 <div class="col-xs-4 offset-xs-1 col-lg-4 offset-lg-1">
														 <strong>Para :</strong> <?php echo $mensaje['receptor']; ?>
														 <div class="row">
															 <div class="col-xs-7 col-lg-7">
																 <strong>De :</strong> <?php echo $mensaje['emisor']; ?>
														 		</div>
														 </div>

		                       </div>
		 											<div class="col-xs-3 offset-xs-3 col-lg-3 offset-lg-3">
														<strong>Fecha :</strong> <?php echo $mensaje['fecha']; ?>
		                       </div>
												 </div>
												 <br>
												 <br>
												 <div class="row">
													 <div class="col-xs-10 offset-xs-1 col-lg-10 offset-lg-1">
														 <?php
														 echo $mensaje['contenido'];
														 if($mensaje['tipo'] == 'Solicitud'){
															 if($solicitud){
																 if(isset($solicitud['fechadia'])){
																	 echo '<br>';
																	 echo '<br>';
																	 echo '<strong>Servicio:</strong> '.$solicitud['servicio'];
																	 echo '<br>';
																	 echo '<strong>Importe Total:</strong> '.$solicitud['importetotal'].'€';
																	 echo '<br>';
																	 echo '<strong>Para el Día:</strong> '.$solicitud['fechadia'];
																	 echo '<br>';
																	 echo '<strong>Dirección:</strong> '.$datosUsuarioSolicitud['direccion'];
																	 echo '<br>';
																	 echo '<strong>Teléfono Móvil:</strong> '.$datosUsuarioSolicitud['telefonomovil'];
																 }else{
																	 echo '<br>';
																	 echo '<br>';
																	 echo '<strong>Servicio:</strong> '.$solicitud['servicio'];
																	 echo '<br>';
																	 echo '<strong>Importe Total:</strong> '.$solicitud['importetotal'].'€';
																	 echo '<br>';
																	 echo '<strong>Desde el Día:</strong> '.$solicitud['fechainicio'];
																	 echo '<br>';
																	 echo '<strong>Hasta el Día</strong>: '.$solicitud['fechafinal'];
																	 echo '<br>';
																	 echo '<strong>Dirección:</strong> '.$datosUsuarioSolicitud['direccion'];
																	 echo '<br>';
																	 echo '<strong>Teléfono Móvil:</strong> '.$datosUsuarioSolicitud['telefonomovil'];
																 }
															 }
														 }
														 ?>
														 <br>
														 <br>
													 </div>
												 </div>
												<hr>
											 </div>
											 <?php
											   foreach($respuestas as $respuesta){
													 $emisor = $respuesta['emisor'];
													 $receptor = $respuesta['receptor'];
													 $fecha = $respuesta['fecha'];
													 $contenido = $respuesta['contenido'];
													 echo '<div class="respuesta">
																	 <div class="row">
																		<div class="col-xs-4 offset-xs-1 col-lg-4 offset-lg-1">
																			<strong>Para : </strong>'.$receptor.'
																			<div class="row">
																				<div class="col-xs-7 col-lg-7">
																				<strong>De : </strong>'.$emisor.'
																			 </div>
																			</div>
																		</div>
																	 <div class="col-xs-3 offset-xs-3 col-lg-3 offset-lg-3">
																		 <strong>Fecha : </strong>'.$fecha.'
																		</div>
																	</div>
																	<br>
																	<br>
																	<div class="row">
																		<div class="col-xs-10 offset-xs-1 col-lg-10 offset-lg-1">
																			'.$contenido.'
																			<br>
																			<br>
																		</div>
																	</div>
																	<hr>
													 			 </div>';
													}
													if($mensaje['tipo'] == 'Solicitud' && $solicitud['solicitudverificada'] == 0){
												?>
													<button style="width: 220px;" onclick="aceptarSolicitud('<?php echo $mensaje['id']; ?>,<?php echo $solicitud['servicio']; ?>')" name="aceptar" id="aceptar" class="btn btn-default"><i class="fas fa-check-circle"></i> Aceptar Solicitud</button>
													<button style="width: 220px;" onclick="rechazarSolicitud('<?php echo $mensaje['id']; ?>')" name="rechazar" id="rechazar" class="btn btn-default"><i class="fas fa-times-circle"></i> Rechazar Solicitud</button>
										<?php	} ?>
											 <button style="width: 220px;" data-toggle="modal" href="#myModal" class="btn btn-default"><i class="far fa-comments"></i> Responder</button>
		 									 <button style="width: 220px;" onclick="location.href='tablonMensajesDuenoCuidador.php';" class="btn btn-default"><i class="fas fa-arrow-alt-circle-left"></i> Volver a mis Mensajes</button>
		 									 <br>
		 									 <br>
										 </div>
									 </div>
                 </div>
         				</div>
								<!-- Modal -->
								<form class="responderMensaje" id="responderMensaje" role="form">
		              <div class="modal fade" id="myModal" role="dialog">
		                <div class="modal-dialog">
		                  <!-- Modal content-->
		                  <div class="modal-content">
		                    <div class="modal-header">
													<div class="col-xs-12 col-md-12 col-lg-12">
		                      	<h3>Para : <?php echo $mensaje['emisor']; ?><span><button type="button" class="close" data-dismiss="modal">&times;</button></span></h3>
													</div>
		                    </div>
		                    <div id="responderModal" class="modal-body">
		                      <div class="row">
		                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mx-auto">
		                            <div id="form-modal" class="form-group">
																	<div class="form-group">
																		<label for="respuesta">Respuesta :</label>
																		<textarea class="form-control" col="12" rows="6" id="respuesta" name="respuesta" required></textarea>
																	</div>
																	<div class="form-group">
																		<input type="hidden" id="idmensaje" name="idmensaje" value="<?=$id; ?>">
																	</div>
		                            </div>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="modal-footer">
		                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto">
														<div id="form-modal" class="form-group">
															<button onclick="responderMensaje($('#idmensaje').val(), $('#respuesta').val())" name="responder" id="responder" class="btn btn-default block"><i class="far fa-comments"></i> Responder</button>
														</div>
		                        <div id="form-modal" class="form-group">
		                          <button class="btn btn-default block" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Volver al Mensaje</button>
		                        </div>
		                      </div>
		                    </div>
		                  </div>
		                </div>
		              </div>
								</form>
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
