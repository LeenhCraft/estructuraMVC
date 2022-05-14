function val_press(e) {
  let input = $(e);
  if (input.val().length != "") {
    $("._disabled").attr("disabled", false);
  } else {
    $("._disabled").attr("disabled", true);
  }
}

function bsc_lector(e) {
  let btn = $(e);
  let txt = btn.html();
  let param = $("#txtCod").val();
  let ajaxUrl = base_url + "incidencias/buscar/" + param;
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"></div>`
  );
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    console.log(objData);
    if (textStatus == "success" && objData.status == true) {
      $("#usu").val(objData.data.idwebusuario);
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
      lstmotivos();
      $(".spinner-grow").removeClass("d-none");
      $("button[disabled]").attr("disabled", false);
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $("#lbldni").html("");
      $("#lbldirec").html("");
      $("#lblcel").html("");
      $("#lblusu").html("");
      $("#imgFoto").attr("src", "https://via.placeholder.com/180x200");
      $("#txtCod").html("");
      $("#txtCod").val("");
      $("#txtCod").focus();
      $(".spinner-grow").addClass("d-none");
    }
    btn.html(txt);
  });
}

function lstreservas(id) {
  $("#tbreservas").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "incidencias/lstreservas/" + id,
      method: "GET",
      dataSrc: "",
    },
    columns: [
      { data: "btn" },
      { data: "cod" },
      { data: "prestamo" },
      { data: "dprestamo" },
      { data: "estado", class: "text-center" },
      //   { data: "options", class: "text-end" },
    ],

    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[1, "asc"]],
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
      url: base_url + "incidencias/lstincidentes/" + param,
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

function lstmotivos() {
  let ajaxUrl = base_url + "incidencias/motivos/";
  $.post(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    if (objData.status) {
      $("#txtIdmotivos").empty();
      $.each(objData.text, function (index, value) {
        $("#txtIdmotivos").append(
          "<option value=" + value.id + ">" + value.nombre + "</option>"
        );
      });
    } else {
      Swal.fire({
        title: objData.title,
        text: objData.text,
        icon: objData.icon,
        confirmButtonText: "ok",
      });
    }
  });
}

function inci(e) {
  let form = $(e).serialize();
  let btn = $(".btn_inci");
  let txt = btn.html();
  let param = $("#txtCod").val();
  let ajaxUrl = base_url + "incidencias/insertinci/";
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $("#divLoading").css("display", "flex");
  $.post(ajaxUrl, form, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      Swal.fire(objData.title, objData.text, objData.icon);
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
    }
    btn.html(txt);
    $("#divLoading").css("display", "none");
    $(e).trigger("reset");
    $("#pres_cod").val("");
    $("#item_book").val("");
    $("#lblisbn").html("");
    $("#lblbook").html("");
    lstincidencias(param);

  });
  return false;
}

function ver_libros(e, param, cod) {
  $(".chio").empty();
  let ajaxUrl = base_url + "incidencias/det";
  let btn = $(e);
  let html = btn.html();
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"></div>`
  );
  // $("#divLoading").css("display", "none");
  btn.attr("disabled", false);
  $.post(ajaxUrl, { a: param }, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      console.log(objData);
      $(".cod_prestamo").html(cod);
      $.each(objData.data, function (index, value) {
        $(".chio").append(
          `
        <div class="col-12 mb-2">
            <div class="form-row">
                <label for="nameBackdrop" class="form-label titulo col col-md-auto text-">` +
            value.art_nombre +
            `</label>
                <button type="button" onclick="add_det_inci(this,` +
            value.idarticulo +
            `,` +
            value.art_isbn +
            `,'` +
            value.art_nombre +
            `')" class="btn btn-xs btn-outline-dark col-md-1 ms-2"><i class='bx bx-plus-circle'></i></button>
            </div>
        </div>
        `
        );
      });
      $("#pres_cod").val(param);
      $("#ver_libro").modal("show");
      btn.html(html);
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      btn.html(html);
    }
    btn.attr("disabled", false);
  });
}

function add_det_inci(e, cod, isbn, titulo) {
  // let ajaxUrl = base_url + "incidencias/insertinci";
  let btn = $(e);
  let html = btn.html();
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"></div>`
  );
  // $("#divLoading").css("display", "none");
  btn.attr("disabled", false);
  $("#lblisbn").html(isbn);
  $("#lblbook").html(titulo);
  $("#item_book").val(cod);
  btn.html(html);
  btn.attr("disabled", false);
  $("#ver_libro").modal("hide");
  $("#fichatitle").collapse("show");
}
