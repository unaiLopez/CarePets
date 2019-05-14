<?php
	@ob_start();
	session_start();

  try {
    //Configurar base de datos
    require_once '../conectarDB.php';

    $conn = conectarse();

		$id = $_SESSION['id'];
		$leido = 1;

    //Tomar mail del usuario
    $correoActual = $_SESSION['mail'];

    //Tomar los datos del mensaje
    $sentencia = $conn->prepare("SELECT * FROM mensaje WHERE mailreceptor=:mailusuario and id=:id");
    $sentencia->bindParam(':mailusuario', $correoActual);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
    $mensaje = $sentencia->fetch(PDO::FETCH_BOTH);

		$sql = "UPDATE mensaje SET leido=? WHERE id=?";
		$sentencia= $conn->prepare($sql);
		$sentencia->execute([$leido,$id]);

		//Conseguir todas las respuestas del mensaje principal
		$sentencia = $conn->prepare("SELECT * FROM mensaje WHERE idrespuesta=:id ORDER BY fecha ASC");
		$sentencia->bindParam(':id', $id);
		$sentencia->execute();
		$respuestas = $sentencia->fetchAll(PDO::FETCH_BOTH);

		require_once 'marcarRespuestasComoLeidas.php';
		require_once 'mensajesNoLeidos.php';
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
     <script src="../../js/mensajeria.js"></script>
   </head>
   <body>
     <div id="container">
       <!-- Navegación -->
       <nav class="navbar navbar-expand-md navbar-light">
         <div class="container-fluid">
           <a class="navbar-brand" href="perfilClinica.php"><img src="../../iconos/barra_navegacion/logo_carepets.png" height="75" width="210"></a>
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
                 <li><a href="perfilClinica.php"><i class="fas fa-user"></i> Perfil</a></li>
                 <hr>
                 <li><a href="../editar/editarClinica.php"><i class="fas fa-user-edit"></i> Editar</a></li>
                 <hr>
                 <li><a href="../mensajeria/tablonMensajes.php"><i class="fas fa-envelope"></i> Mensajes</a></li>
                 <hr>
                 <li><a href="#"><i class="fas fa-users"></i> Foro</a></li>
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
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#recibidos" role="tab" aria-controls="contraseña" aria-selected="true">Recibidos <span class="badge badge-primary badge-pill"><?php echo $notificaciones; ?></span></a>
                   </li>
                 </ul>
               </div>
               <div class="col-lg-12 scroll">
                 <div class="card-body mx-auto">
                   <div class="tab-content" id="myTabContent">
										 <div class="mensaje">

											 <div class="row">
												 <div class="col-xs-4 offset-xs-1 col-lg-4 offset-lg-1">
													 <strong>Para :</strong> <?php echo $mensaje['mailreceptor']; ?>
													 <div class="row">
														 <div class="col-xs-7 col-lg-7">
															 <strong>De :</strong> <?php echo $mensaje['mailemisor']; ?>
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
													 <?php echo $mensaje['contenido']; ?>
													 <br>
													 <br>
												 </div>
											 </div>
											 <div class="row">
												 <div class="col-xs-12 col-lg-12">
													 <hr>
												 </div>
											 </div>
										 </div>
										 <?php
										   foreach($respuestas as $respuesta){
												 $mailemisor = $respuesta['mailemisor'];
												 $mailreceptor = $respuesta['mailreceptor'];
												 $fecha = $respuesta['fecha'];
												 $contenido = $respuesta['contenido'];
												 echo '<div class="respuesta">
																 <div class="row">
																	<div class="col-xs-4 offset-xs-1 col-lg-4 offset-lg-1">
																		<strong>Para : </strong>'.$mailreceptor.'
																		<div class="row">
																			<div class="col-xs-7 col-lg-7">
																			<strong>De : </strong>'.$mailemisor.'
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
																<div class="row">
																	<div class="col-xs-12 col-lg-12">
																		<hr>
																	</div>
																</div>
												 			 </div>';
												}
											?>
										 <button data-toggle="modal" href="#myModal" class="btn btn-default"><i class="far fa-comments"></i> Responder</button>
	 									 <button onclick="location.href='tablonMensajes.php';" class="btn btn-default"><i class="fas fa-arrow-alt-circle-left"></i> Volver a mis Mensajes</button>
	 									 <br>
	 									 <br>
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
	                      <strong>Para : </strong><?php echo $mensaje['mailemisor']; ?><span><button type="button" class="close" data-dismiss="modal">&times;</button></span>
	                    </div>
	                    <div class="modal-body">
	                      <div class="row">
	                        <div class="col-xs-12 mx-auto">
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
	                      <div class="col-xs-12 mx-auto">
													<div id="form-modal" class="form-group">
														<button onclick="responderMensaje($('#idmensaje').val(), $('#respuesta').val())" name="responder" id="responder" class="btn btn-default"><i class="far fa-comments"></i> Responder</button>
													</div>
	                        <div id="form-modal" class="form-group">
	                          <button class="btn btn-default" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Volver al Mensaje</button>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                </div>
	              </div>
							</form>
       </div>
       <br>
       <br>
       <!-- Footer -->
   		</div>
			</div>
		</div>
   </body>
 </html>
