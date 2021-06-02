function checkear(obj) {
  hijos = obj.children;
  for (var i = 0; i < hijos.length; i++) {
    if (hijos[i].type == "checkbox") {
      if (hijos[i].checked == true) {
        hijos[i].checked = false;
      } else {
        hijos[i].checked = true;
      }
    }
  }
}

/**
 * Funcion para mostrar u ocultar la pantalla de transwicion
 * @param {boolean} activar Para activar o desactivar la pantallas de transicion
 * @param {String} titulo  para ingresar un titulo de la pantalla de transicion
 * @param {String} mensaje Para describir un poco mas la pantallas de transiciion
 */
const spinner = (
  activar = false,
  titulo = "Espere por favor",
  mensaje = "El sistema esta realizando tareas de comprobación aguarde un momento por favor.."
) => {
  document.querySelector(".transicion .titulo").innerHTML = titulo;
  document.querySelector(".transicion .mensaje").innerHTML = mensaje;
  if (activar) {
    document.querySelector(".transicion").style.display = "grid";
  } else {
    document.querySelector(".transicion").style.display = "none";
  }
};

$(document).ready(() => {
  spinner(false);
});
