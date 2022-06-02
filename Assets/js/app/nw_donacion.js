$(document).ready(function () {
  $("#donante").select2({
    theme: "bootstrap4",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    // placeholder: "Donante",
    // allowClear: Boolean($(this).data("allow-clear")),
    // closeOnSelect: !$(this).attr("multiple"),
  });
  select_libros($(".nav-link.active"));
  load_cod($(".cod_ficha"));
});

function lstlibros(param) {
  let ajaxUrl = base_url + "prestamos/lstlibros";
  $.get(ajaxUrl, function (data) {
    $("#libros").html(data);
  });
}

function agregarDetalle() {
  var libro_id = $("#libros").find(":selected").val();
  var libro_titulo = $("#libros").find(":selected").text();
  var cantidad = $("#detll3").val();
  var tabladet = $("#tabledetalle tbody");

  if (cantidad != "") {
    if (libro_id != "") {
      var detalle = tabladet.find('tr[data-id="' + libro_id + '"]');
      if ($(detalle).length) {
        var inputcant = detalle.find("input.cant");
        var cantotal = parseInt(cantidad) + parseInt(inputcant.val());
        inputcant.val(cantotal);
      } else {
        tabladet.prepend(`
              <tr data-id="${libro_id}" style="display:none">
                  <td scope="row">
                      <input type="hidden" name="libro[]" value="${libro_id}">
                      ${libro_titulo}
                  </td>
                  <td><input class="form-control form-control-sm cant text-center" name="cant[]" type="text" value="${cantidad}"></td>
                  <td>
                      <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" onclick="mostrarInformacionDetalle(ths, evnt, ${libro_id})" class="btn btn-sm py-0 btn-warning d-none">
                            <i class='bx bx-search-alt-2'></i>
                          </button>
                          <button type="button" onclick="eliminarDetalle(this, event, '${libro_id}')" class="btn btn-sm py-0 btn-danger">
                            <i class='bx bx-trash'></i>
                          </button>
                      </div>
                  </td>
              </tr>`);
        $('[data-id="' + libro_id + '"]').show("fast");
      }
      $("#libros").val(null).trigger("change");
      $("#detll3").val(1);
    } else {
      $("#libros").select2("open");
    }
  }
}

function eliminarDetalle(ths, evnt, id) {
  evnt.preventDefault();
  var detalle = $('[data-id="' + id + '"]');
  if ($(detalle).length) {
    detalle.hide("fast", function () {
      detalle.remove();
    });
  }
}

function load_cod(e) {
  $(e).html(
    `<div class="spinner-border spinner-border-sm fw- text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  let ajaxUrl = base_url + "donacion/ajax/op3";
  $.get(ajaxUrl, function (data, textStatus) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        $(e).removeClass("text-center").html(objData["data"]);
        $("#cod_ficha").val(objData["data"]);
      } else {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
    }
  });
}

function select_libros(e) {
  let content = $(e).attr("data-bs-target");
  let ajaxUrl = base_url + "donacion/ajax/op1";
  if ($(content).html() == "") {
    $(content)
      .addClass("text-center")
      .html(
        `<div class="spinner-border spinner-border-lg text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`
      );
    $.get(ajaxUrl, function (data, textStatus) {
      if (textStatus == "success") {
        let objData = JSON.parse(data);
        if (objData["status"]) {
          $(content).removeClass("text-center").html(objData["data"]);
        } else {
          Swal.fire({
            title: objData.title,
            text: objData.text,
            icon: objData.icon,
            confirmButtonText: "ok",
          });
        }
      }
    });
  }
}

function new_libro(e) {
  let content = $(e).attr("data-bs-target");
  let ajaxUrl = base_url + "donacion/ajax/op2";
  $(content)
    .addClass("text-center")
    .html(
      `<div class="spinner-border spinner-border-lg text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`
    );
  $.get(ajaxUrl, function (data, textStatus) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        $(content).removeClass("text-center").html(objData["data"]);
      } else {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
    }
  });
}

function bsc_pro(e) {
  let btn = $("#button-addon2");
  let txt = btn.html();
  let param = $("#txtdoc").val();
  let ajaxUrl = base_url + "donacion/ajax/proveedor";
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $.get(ajaxUrl, { a: param }, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      $("#idprove").val(objData.data.idprodon);
      $(".lbldoc").html(objData.data.doc);
      $("#lblnombre")
        .html(objData.data.nombre)
        .addClass("text-primary fw-bold");
      $("#lbldirec").html(
        objData.data.pro_direccion == null
          ? "sin direccion"
          : objData.data.pro_direccion
      );
      $("#lblcel").html(
        objData.data.pro_nmr_celular == null
          ? "sin celular"
          : objData.data.pro_nmr_celular
      );
      $("#lblemail").html(objData.data.pro_email);
      // $("#imgFoto").attr("src", objData.data.usu_foto);

      btn.html(txt);
      $(".div_hidden").show("slow");
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $(".lbldoc").html("");
      $("#lbldirec").html("");
      $("#lblcel").html("");
      $("#lblemail").html("");
      $("#imgFoto").attr("src", "https://via.placeholder.com/180x270");
      $("#txtdoc").focus();
      btn.html(txt);
      $(".div_hidden").hide("slow");
    }
  });
  return false;
}

function fn_submit_form(e) {
  let form = $(e);
  let data = new FormData(form[0]);
  let _url = base_url + "donacion/registrar";
  let btn = form.find('[type="submit"]');
  btn.removeClass("btn-outline-primary");
  btn.addClass("btn-outline-danger");
  btn.html(
    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
  );
  btn.attr("disabled", true);
  $.ajax({
    type: "POST",
    url: _url,
    data: data,
    processData: false,
    contentType: false,
    success: function (response) {
      var objData = JSON.parse(response);
      btn.html("<i class='bx bx-check-circle me-2'></i>guardar donación");
      btn.removeClass("btn-outline-danger");
      btn.addClass("btn-outline-primary");
      btn.attr("disabled", false);
      Swal.fire(objData.title, objData.text, objData.icon);
      if (objData.status == true) {
        form.trigger("reset");
        $("#idprove").val("");
        $("#cod_ficha").val("");
        $("#tabledetalle tbody").html("");
        $(".div_hidden").hide("slow");
        $("#txtdoc").val("");
        load_cod($(".cod_ficha"));
      }
    },
  });
  return false;
}
