$(document).ready(function(){
  var boolCorreo = false;
  var boolContraseña = false;
  var boolContraseñaActual = false;
  var boolInicioSesion = false;
  var boolCorreoEditar = false;
  var boolMovil = false;
  var boolMovilEditar = false;
  var boolFijoEditar = false;
  var boolFijo = false;
  var boolBusqueda = false;
});

function validarContraseña(pass, confirmarpass){
  if(pass == confirmarpass && pass.length > 5 && confirmarpass.length > 5){
    boolContraseña = true;
    $("#compararContraseñas").html("La contraseña y su confirmación son correctas.").css("color","green");
  }else{
    boolContraseña = false;
    $("#compararContraseñas").html("La contraseña o su confirmacion son incorrectas.").css("color","red");
  }
  return boolContraseña;
}

function validarContraseñaActual(pass){
  var contraseña = {"pass" : pass};
  $.ajax({
    data: contraseña,
    url: '/carepets/validaciones/validarContraseñaActual.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolContraseñaActual = true;
        $("#validacionContraseñaActual").html("La contraseña actual es correcta.").css("color","green");
      }else{
        boolContraseñaActual = false;
        $("#validacionContraseñaActual").html("La contraseña actual es incorrecta.").css("color","red");
      }
    }
  });
  return boolContraseñaActual;
}

function compararTelefonos(movil, fijo){
  if(movil == fijo) {
    $("#compararTelefonos").html("El teléfono móvil y el teléfono fijo no pueden ser iguales.").css("color","red");
    return false;
  }else{
    $("#compararTelefonos").html("El teléfono móvil y el teléfono fijo son diferentes.").css("color","green");
    return true;
  }
}

function validarDatosInicioSesion(pass, mail){
  var datos = {"pass" : pass, "mail" : mail};
  $.ajax({
    data: datos,
    url: '/carepets/validaciones/validarDatosInicioSesion.php',
    type: 'post',
    async: false,
    success: function(response){
      if(response == true){
        boolInicioSesion = true;
      }else{
        boolInicioSesion = false;
        $("#validacionInicioSesion").html("El correo o la contraseña son incorrectas.").css("color","red");
      }
    }
  });

  return boolInicioSesion;
}

function validarCorreo(mail){
  var mail = {"mail" : mail};
  $.ajax({
    data: mail,
    url: '/carepets/validaciones/validarCorreo.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolCorreo = true;
        $("#autenticacionCorreo").html("El correo esta disponible.").css("color","green");
      }else{
        boolCorreo = false;
        $("#autenticacionCorreo").html("El correo esta ya registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return boolCorreo;
}

function validarCorreoEditar(mail){
  var mail = {"mail" : mail};
  $.ajax({
    data: mail,
    url: '/carepets/validaciones/validarCorreoEditar.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolCorreoEditar = true;
        $("#autenticacionCorreo").html("El correo esta disponible.").css("color","green");
      }else{
        boolCorreoEditar= false;
        $("#autenticacionCorreo").html("El correo esta ya registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return boolCorreoEditar;
}

function validarTelefonoMovil(movil){
  var movil = {"movil" : movil};
  $.ajax({
    data: movil,
    url: '/carepets/validaciones/validarTelefonoMovil.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolMovil = true;
        $("#telefonoMovil").html("El teléfono móvil esta disponible.").css("color","green");
      }else{
        boolMovil = false;
        $("#telefonoMovil").html("El teléfono móvil ya está registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return boolMovil;
}

function validarTelefonoMovilEditar(movil){
  var movil = {"movil" : movil};
  $.ajax({
    data: movil,
    url: '/carepets/validaciones/validarTelefonoMovilEditar.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolMovilEditar = true;
        $("#telefonoMovil").html("El teléfono móvil es correcto.").css("color","green");
      }else{
        boolMovilEditar = false;
        $("#telefonoMovil").html("El formato del teléfono móvil es incorrecto.").css("color","red");
      }
    }
  });
  return boolMovilEditar;
}

function validarTelefonoFijoEditar(fijo){
  var fijo = {"fijo" : fijo};
  $.ajax({
    data: fijo,
    url: '/carepets/validaciones/validarTelefonoFijoEditar.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolFijoEditar = true;
        $("#telefonoFijo").html("El teléfono fijo es correcto.").css("color","green");
      }else{
        boolFijoEditar = false;
        $("#telefonoFijo").html("El formato del teléfono fijo es incorrecto.").css("color","red");
      }
    }
  });
  return boolFijoEditar;
}

function validarTelefonoFijo(fijo){
  var fijo = {"fijo" : fijo};
  $.ajax({
    data: fijo,
    url: '/carepets/validaciones/validarTelefonoFijo.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolFijo = true;
        $("#telefonoFijo").html("El teléfono fijo esta disponible.").css("color","green");
      }else{
        boolFijo = false;
        $("#telefonoFijo").html("El teléfono fijo ya está registrado o es incorrecto.").css("color","red");
      }
    }
  });
  return boolFijo;
}

function validarMenuBusqueda(busco, servicio, date1, date2, date3){
  var datos = {"busco" : busco, "servicio" : servicio, "date1" : date1, "date2" : date2, "date3" : date3}
  $.ajax({
    data: datos,
    url: '/carepets/validaciones/validarMenuBusqueda.php',
    type: 'post',
    async: true,
    success: function(response){
      if(response == true){
        boolBusqueda = true;
        $("#validarDatos").html("Los datos introducidos son correctos.").css("color","green");
      }else{
        boolBusqueda = false;
        $("#validarDatos").html("Los datos introducidos son incorrectos.").css("color","red");
      }
    }
  });
  return boolBusqueda;
}
