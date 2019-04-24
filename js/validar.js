function validarContraseña(pass, confirmarpass){
  var bool = false;
  var contraseñas = {"pass" : pass, "confirmarpass" : confirmarpass};
  $.ajax({
    data: contraseñas,
    url: '/carepets/validaciones/validarContraseñas.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#compararContraseñas").html("La contraseña y su confirmación son correctas.").css("color","green");
        bool = true;
      }else{
        $("#compararContraseñas").html("La contraseña o su confirmacion son incorrectas.").css("color","red");
      }
    }
  });
  return bool;
}

function validarContraseñaActual(pass){
  var bool = false;
  var contraseña = {"pass" : pass};
  $.ajax({
    data: contraseña,
    url: '/carepets/validaciones/validarContraseñaActual.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#validacionContraseñaActual").html("La contraseña actual es correcta.").css("color","green");
        bool = true;
      }else{
        $("#validacionContraseñaActual").html("La contraseña actual es incorrecta.").css("color","red");
      }
    }
  });
  return bool;
}

function validarDatosInicioSesion(pass, mail){
  var bool = false;
  var datos = {"pass" : pass, "mail" : mail};
  $.ajax({
    data: datos,
    url: '/carepets/validaciones/validarDatosInicioSesion.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        bool = true;
      }else{
        $("#validacionInicioSesion").html("El correo o la contraseña son incorrectas.").css("color","red");
      }
    }
  });
  return bool;
}

function validarCorreo(mail){
  var bool = false;
  var mail = {"mail" : mail};
  $.ajax({
    data: mail,
    url: '/carepets/validaciones/validarCorreo.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#autenticacionCorreo").html("El correo esta disponible.").css("color","green");
        bool = true;
      }else{
        $("#autenticacionCorreo").html("El correo esta ya registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return bool;
}

function validarCorreoEditar(mail){
  var bool = false;
  var mail = {"mail" : mail};
  $.ajax({
    data: mail,
    url: '/carepets/validaciones/validarCorreoEditar.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#autenticacionCorreo").html("El correo esta disponible.").css("color","green");
        bool = true;
      }else{
        $("#autenticacionCorreo").html("El correo esta ya registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return bool;
}

function validarTelefonoMovil(movil){
  var bool = false;
  var movil = {"movil" : movil};
  $.ajax({
    data: movil,
    url: '/carepets/validaciones/validarTelefonoMovil.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#telefonoMovil").html("El teléfono móvil esta disponible.").css("color","green");
        bool = true;
      }else{
        $("#telefonoMovil").html("El teléfono móvil ya está registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return bool;
}

function validarTelefonoMovilEditar(movil){
  var bool = false;
  var movil = {"movil" : movil};
  $.ajax({
    data: movil,
    url: '/carepets/validaciones/validarTelefonoMovilEditar.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#telefonoMovil").html("El teléfono móvil es correcto.").css("color","green");
        bool = true;
      }else{
        $("#telefonoMovil").html("El formato del teléfono móvil es incorrecto.").css("color","red");
      }
    }
  });
  return bool;
}

function validarTelefonoFijoEditar(fijo){
  var bool = false;
  var fijo = {"fijo" : fijo};
  $.ajax({
    data: fijo,
    url: '/carepets/validaciones/validarTelefonoFijoEditar.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#telefonoFijo").html("El teléfono fijo es correcto.").css("color","green");
        bool = true;
      }else{
        $("#telefonoFijo").html("El formato del teléfono fijo es incorrecto.").css("color","red");
      }
    }
  });
  return bool;
}

function validarTelefonoFijo(fijo){
  var bool = false;
  var fijo = {"fijo" : fijo};
  $.ajax({
    data: fijo,
    url: '/carepets/validaciones/validarTelefonoFijo.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        $("#telefonoFijo").html("El teléfono fijo esta disponible.").css("color","green");
        bool = true;
      }else{
        $("#telefonoFijo").html("El teléfono fijo ya está registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return bool;
}
