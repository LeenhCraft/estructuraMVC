$(document).ready(function () {
  $("select").select2({
    theme: "bootstrap4",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
    placeholder: "Nombre de libro",
    allowClear: Boolean($(this).data("allow-clear")),
    closeOnSelect: !$(this).attr("multiple"),
  });
  lstlibros();
});

function bsc_lector(e) {
  let btn = $("#button-addon2");
  let txt = btn.html();
  let param = $("#txtCod").val();
  let ajaxUrl = base_url + "prestamos/buscar/" + param;
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      $("#detlec").val(objData.data.idwebusuario);
      $("#lblnombre")
        .html(objData.data.usu_nombre)
        .addClass("text-primary fw-bold");
      $("#lbldni").html(objData.data.usu_dni);
      $("#lbldirec").html(
        objData.data.usu_direc == null
          ? "sin direccion"
          : objData.data.usu_direc
      );
      $("#lblcel").html(
        objData.data.usu_cel == null ? "sin celular" : objData.data.usu_cel
      );
      $("#lblusu").html(objData.data.usu_usuario);
      $("#imgFoto").attr("src", objData.data.usu_foto);
      lstreservas(param);
      lstincidencias(param);
      $(".spinner-grow").removeClass("d-none");
      $("button[disabled]").attr("disabled", false);
      btn.html(txt);
      $(".div_hidden").show("slow");
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $("#lbldni").html("");
      $("#lbldirec").html("");
      $("#lblcel").html("");
      $("#lblusu").html("");
      $("#imgFoto").attr("src", "https://via.placeholder.com/180x270");
      $("#txtCod").html("");
      $("#txtCod").val("");
      $("#txtCod").focus();
      $(".spinner-grow").addClass("d-none");
      btn.html(txt);
      $(".div_hidden").hide("slow");
    }
  });
  return false;
}

function lstreservas(id) {
  $("#tbreservas").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "prestamos/lstreservas/" + id,
      method: "GET",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "cantidad" },
      { data: "prestamo" },
      { data: "devolucion" },
      { data: "estado", class: "text-center" },
      //   { data: "options", class: "text-end" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
  });
}

function lstincidencias(param) {
  $("#tbincidencias").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "prestamos/lstincidentes/" + param,
      method: "GET",
      dataSrc: "",
    },
    columns: [
      { data: "idprestamo" },
      { data: "cod_prestamo" },
      { data: "motivo", class: "text-start" },
      { data: "libro" },
      { data: "fecha", class: "text-start" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
  });
}

function gen_servicio(e) {
  let btn = $(e);
  let txt = btn.html();
  let param = $("#txtCod").val();
  let ajaxUrl = base_url + "prestamos/buscar/" + param;
  btn.html(`<div class="spinner-border spinner-border-sm text-light" role="status">
  <span class="visually-hidden">Loading...</span>
</div> generar servicio`);
  $("#spinner").css("display", "flex");
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    let ajaxUrl = base_url + "prestamos/getServices/" + param;
    if (textStatus == "success" && objData.status == true) {
      $.get(ajaxUrl, function (data, textStatus, jqXHR) {
        if (textStatus == "success") {
          $("#step1").parent().html(`<div id="step2" class="card"></div>`);
          $("#step1").remove();
          $("#step2").html(data);
        }
      });
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $("#lbldni").html("");
      $("#lbldirec").html("");
      $("#lblcel").html("");
      $("#lblusu").html("");
      $("#imgFoto").attr("src", "https://via.placeholder.com/180x270");
      $("#txtCod").html("");
      $("#txtCod").val("");
      $("#txtCod").focus();
      $(".spinner-grow").addClass("d-none");
      $("#spinner").css("display", "none");
      btn.html(txt);
    }
  });
}

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
                  <td><input class="form-control form-control-sm cant" name="cant[]" type="text" value="${cantidad}"></td>
                  <td>
                      <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" onclick="mostrarInformacionDetalle(ths, evnt, ${libro_id})" class="btn btn-sm py-0 btn-warning">
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

function fn_submit_form(e) {
  var form = $(e);
  var data = new FormData(form[0]);

  if (form[0].checkValidity() === false) {
    form[0].classList.add("was-validated");
  } else {
    var btn = form.find('[type="submit"]');
    btn.removeClass("btn-outline-primary");
    btn.addClass("btn-outline-danger");
    btn.html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
    );
    btn.attr("disabled", true);
    var _url = base_url + "prestamos/registrar";

    $.ajax({
      type: "POST",
      url: _url,
      data: data,
      processData: false,
      contentType: false,
      success: function (response) {
        var objData = JSON.parse(response);
        btn.html("Generar Servicio");
        btn.removeClass("btn-outline-danger");
        btn.addClass("btn-outline-primary");
        btn.attr("disabled", false);
        Swal.fire(objData.title, objData.text, objData.icon);
        if (objData.status == true) {
          form.trigger("reset");
          $("#idform").val("");
          $("#tabledetalle tbody").html("");
          $(".div_hidden").hide("slow");
          $("#txtCod").val("");
        }
      },
    });
  }

  return false;
}
