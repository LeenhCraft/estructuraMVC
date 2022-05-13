const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  showCloseButton: true,
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
  if (valor != "") {
    $.get(api + valor, function (data, textStatus, jqXHR) {
      spinner.removeAttr("class").attr("class", clas);
      input.attr("disabled", false);
      if (jqXHR.status == 200) {
        $(".term_bus").html(valor);
        $(".term_cant").html(data.items.length);
        contenido.empty();
        $.each(data.items, function (index, value) {
          let cod = value.id;
          let des = "Sin descripción";
          let titulo = "Sin título";
          let autor = "Sin autor";
          value.volumeInfo.description != undefined
            ? (des = value.volumeInfo.description.replace(/\s+/g, " ").trim())
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
                    <button class="btn btn-primary btn-sm" onclick="add_db(this,'` +
              cod +
              `',` +
              "`" +
              titulo +
              "`" +
              `,` +
              "`" +
              des +
              "`" +
              `)">Agregar a la DB</button>
                </div>
            </div>
          </div>
          `
          );
        });
      } else {
        contenido
          .empty()
          .html(
            `<label class="text-center text-primary h4">No hay resultados</label>`
          );
      }
    });
  } else {
    spinner.removeAttr("class").attr("class", clas);
    input.attr("disabled", false);
    contenido
      .empty()
      .html(
        `<label class="text-center text-primary h4">No hay resultados</label>`
      );
  }

  return false;
}

function cerrar() {
  $(".div_search").hide("slow");
}

function add_db(ths, cod, titulo, descr) {
  let btn = $(ths);
  let loading = `<div class="spinner-border spinner-border-sm text-white mx-auto" role="status"><span class="visually-hidden">Loading...</span></div>`;
  btn.html(loading + "  Agregando");
  let ajaxUrl = base_url + "dashboard/add";
  $.post(ajaxUrl, { cod: cod, title: titulo, des: descr }, function (data) {
    let objData = JSON.parse(data);
    if (objData.status == true) {
      console.log(objData.text);
      btn
        .html("<i class='bx bx-check me-2'></i>Agregado")
        .removeAttr("class")
        .attr("class", "btn btn-outline-primary btn-sm")
        .attr("disabled", true);
    } else {
      console.log(objData.text);
      let clas = "btn btn-outline-" + objData.icon + " btn-sm";
      btn
        .html("<i class='bx bx-error-alt me-2'></i>" + objData.text)
        .removeAttr("class")
        .attr("class", clas)
        .attr("disabled", true);
    }
  });
}

function add_carrito(e, id) {
  let ajaxUrl = base_url + "web/add";
  var canti = 1;
  if ($("#quantity").length > 0) {
    var input = $("#quantity").val();
    canti = input != "" ? input : 1;
  }

  var datos = {
    id: id,
    cant: canti,
  };
  $.post(ajaxUrl, datos, function (data, textStatus, jqXHR) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      Toast.fire({
        icon: objData.icon,
        title: objData.text,
      });
      if (objData.status == true) {
        $("#cantcar").find(".cant_car").show("slow").html(objData.data);
      }
    }
  });

  return false;
}
