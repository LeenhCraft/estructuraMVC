let divLoading = $("#divLoading");
let tb;

$(document).ready(function () {
  tb = $("#sis_submenus").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "submenus/listar",
      method: "POST",
      dataSrc: "",
    },
    columns: [
      { data: "nmr", class: "text-left" },
      { data: "menu" },
      { data: "submenu", class: "font-weight-bold" },
      { data: "url", class: "text-left" },
      { data: "orden", class: "text-center" },
      { data: "ver", class: "text-center" },
      { data: "options", class: "text-center" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    // order: [[1, "desc"]],
  });

  $("#formsubmenus").submit(function (event) {
    event.preventDefault();
    let sub_nombre = $("#txtSub_nombre").val();
    let sub_url = $("#txtSub_url").val();
    let sub_controlador = $("#txtSub_controlador").val();
    let form = $("#formsubmenus").serialize();
    if (sub_nombre == "") {
      Swal.fire(
        "Atención",
        "Es necesario un nombre para el submenu.",
        "warning"
      );
      return false;
    }
    if (sub_url == "") {
      Swal.fire("Atención", "Es necesario una url para el submenu.", "warning");
      return false;
    }
    if (sub_controlador == "") {
      Swal.fire(
        "Atención",
        "Es necesario el controlador para el submenu.",
        "warning"
      );
      return false;
    }
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "submenus/acc";
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      $("#modalsubmenus").modal("hide");
      if (objData.status) {
        Swal.fire("submenus", objData.text, "success");
        tb.api().ajax.reload();
      } else {
        Swal.fire("Error", objData.text, "warning");
      }
      divLoading.css("display", "none");
    });
  });
});

function fntView(id) {
  let ajaxUrl = base_url + "submenus/buscar/" + id;
  $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    $("#idsubmenu").html(objData.data.idsubmenu);
    $("#idmenu").html(objData.data.idmenu);
    $("#sub_nombre").html(objData.data.sub_nombre);
    $("#sub_url").html(objData.data.sub_url);
    $("#sub_controlador").html(objData.data.sub_controlador);
    $("#sub_icono").html(objData.data.sub_icono);
    $("#sub_orden").html(objData.data.sub_orden);
    $("#sub_visible").html(objData.data.sub_visible);
    $("#sub_fecha").html(objData.data.sub_fecha);
    $("#mdView").modal("show");
  });
}

function fntEdit(id) {
  let ajaxUrl = base_url + "submenus/buscar/" + id;
  $("#titleModal").html("Actualizar submenus");
  $(".modal-header").removeClass("headerRegister");
  $(".modal-header").addClass("headerUpdate");
  $("#btnActionForm").removeClass("btn-primary");
  $("#btnActionForm").addClass("btn-info");
  $(".div_id").removeClass("d-none");
  $("#btnText").html("Actualizar");
  $("#modalsubmenus").modal("show");
  //
  $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    if (objData.status) {
      $("#item").val(objData.data.idsubmenu);
      $("#txtIdsubmenu").val(objData.data.idsubmenu);
      $("#txtSub_nombre").val(objData.data.sub_nombre);
      $("#txtSub_url").val(objData.data.sub_url);
      $("#txtSub_controlador").val(objData.data.sub_controlador);
      $("#txtSub_icono").val(objData.data.sub_icono);
      $("#txtSub_orden").val(objData.data.sub_orden);
      $("#txtSub_visible").val(objData.data.sub_visible);
      $("#txtSub_fecha").val(objData.data.sub_fecha);
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

function fntDel(idp) {
  Swal.fire({
    title: "Eliminar submenus",
    text: "¿Realmente quiere eliminar submenus?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      let ajaxUrl = base_url + "/submenus/eliminar/" + idp;
      $.post(ajaxUrl, function (data) {
        let objData = JSON.parse(data);
        if (objData.status) {
          Swal.fire({
            title: objData.title,
            text: objData.text,
            icon: objData.icon,
            confirmButtonText: "ok",
          });
          tb.DataTable().ajax.reload();
        } else {
          Swal.fire({
            title: objData.title,
            text: objData.text,
            icon: objData.icon,
            confirmButtonColor: "#007065",
            confirmButtonText: "ok",
          });
        }
      });
    }
  });
}

function openModal() {
  $(".modal-header").removeClass("headerUpdate");
  $(".modal-header").addClass("headerRegister");
  $("#btnActionForm").removeClass("btn-info");
  $("#btnActionForm").addClass("btn-primary");
  $("#btnText").html("Guardar");
  $("#titleModal").html("Nuevo submenus");
  $(".div_id").addClass("d-none");
  $("#formsubmenus").trigger("reset");
  $("#modalsubmenus").modal("show");
}
