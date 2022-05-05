const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

// Funcion para limitar el numero de caracteres de un textarea o input
// Tiene que recibir el evento, valor y número máximo de caracteres
function limitar(e, contenido, caracteres) {
  // obtenemos la tecla pulsada
  var unicode = e.keyCode ? e.keyCode : e.charCode;

  // Permitimos las siguientes teclas:
  // 8 backspace
  // 46 suprimir
  // 13 enter
  // 9 tabulador
  // 37 izquierda
  // 39 derecha
  // 38 subir
  // 40 bajar
  if (
    unicode == 8 ||
    unicode == 46 ||
    unicode == 13 ||
    unicode == 9 ||
    unicode == 37 ||
    unicode == 39 ||
    unicode == 38 ||
    unicode == 40
  )
    return true;

  // Si ha superado el limite de caracteres devolvemos false
  if (contenido.length >= caracteres) return false;

  return true;
}

function buscar_book(e) {
  let input = $(e).find('input[type="text"]');
  let valor = input.val();
  let div = $(".div_search");
  let api = "https://www.googleapis.com/books/v1/volumes?q=";
  let spinner = $(e).find("#ico-search");
  let clas = spinner.attr("class");
  let contenido = $(".cont_result");
  let clas2 = "spinner-border spinner-border-sm text-primary";
  let loading = `<div class="spinner-border spinner-border-lg text-secondary mx-auto" role="status"><span class="visually-hidden">Loading...</span></div>`;
  spinner.removeAttr("class");
  spinner.attr("class", clas2);
  input.attr("disabled", true);
  div.show("slow");
  contenido.empty().append(loading);
  $.get(api + valor, function (data) {
    spinner.removeAttr("class");
    spinner.attr("class", clas);
    input.attr("disabled", false);
    $(".term_bus").html(valor);
    $(".term_cant").html(data.items.length);
    contenido.empty();
    $.each(data.items, function (index, value) {
      let des = "Sin descripción";
      let titulo = "Sin título";
      let autor = "Sin autor";
      value.volumeInfo.description != undefined
        ? (des = value.volumeInfo.description)
        : (des = "Sin descripción");
      value.volumeInfo.title != undefined
        ? (titulo = value.volumeInfo.title)
        : (titulo = "Sin título");
      value.volumeInfo.authors != undefined
        ? (autor = value.volumeInfo.authors)
        : (autor = "Sin autor");
      contenido.append(
        `
      <div class="col-12 col-md-4 ">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title text-truncate">` +
          titulo +
          `</h5>
                <div class="card-subtitle text-muted mb-3 text-truncate">` +
          autor +
          `</div>
                <p class="card-text text-truncate">
                    ` +
          des +
          `
                </p>
                <a href="javascript:void(0)" class="card-link">Card link</a>
                <a href="javascript:void(0)" class="card-link">Another link</a>
            </div>
        </div>
      </div>
      `
      );
    });
  });
  return false;
}

function isKeyExists(obj, key) {
  if (obj[key] == undefined) {
    return false;
  } else {
    return true;
  }
}

function cerrar() {
  $(".div_search").hide("slow");
}