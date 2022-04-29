$(document).ready(function () {});

function bsc_lector() {
  let param = $("#txtCod").val();
  let ajaxUrl = base_url + "prestamos/buscar/" + param;
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      $("#lblnombre").html(objData.data.usu_nombre);
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
    }
  });
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
