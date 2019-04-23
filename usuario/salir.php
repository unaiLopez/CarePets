<?php
	session_start();
	session_destroy();
  //Redireccionar a la página de inicio
  header('Location: ../index.html');
?>
