let divLoading = $("#divLoading");
let tb;

$(document).ready(function () {
  tb = $("#sis_rol").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "Roles/listar",
      method: "POST",
      dataSrc: "",
    },
    columns: [
      { data: "idrol" },
      { data: "rol_nombre" },
      { data: "rol_cod" },
      { data: "rol_descripcion" },
      { data: "rol_estado" },
      { data: "rol_fecha" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });

  $("#formRol").submit(function (event) {
    event.preventDefault();
    let idrol = $("#txtIdrol").val();
    let rol_nombre = $("#txtRol_nombre").val();
    let rol_cod = $("#txtRol_cod").val();
    let rol_descripcion = $("#txtRol_descripcion").val();
    let rol_estado = $("#txtRol_estado").val();
    let rol_fecha = $("#txtRol_fecha").val();
    if (rol_nombre == "") {
      Swal.fire("Atención", "El ´rol_nombre´ es necesario.", "warning");
      return false;
    }
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "Roles/acc";
    $.post(
      ajaxUrl,
      {
        idrol: idrol,
        rol_nombre: rol_nombre,
        rol_cod: rol_cod,
        rol_descripcion: rol_descripcion,
        rol_estado: rol_estado,
        rol_fecha: rol_fecha,
      },
      function (data) {
        let objData = JSON.parse(data);
        $("#modalRol").modal("hide");
        if (objData.status) {
          Swal.fire("Rol", objData.text, "success");
          tb.api().ajax.reload();
        } else {
          Swal.fire("Error", objData.text, "warning");
        }
        divLoading.css("display", "none");
      }
    );
  });
});

function fntView(id) {
  let ajaxUrl = base_url + "Roles/buscar/" + id;
  $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    $("#idrol").html(objData.data.idrol);
    $("#rol_nombre").html(objData.data.rol_nombre);
    $("#rol_cod").html(objData.data.rol_cod);
    $("#rol_descripcion").html(objData.data.rol_descripcion);
    $("#rol_estado").html(objData.data.rol_estado);
    $("#rol_fecha").html(objData.data.rol_fecha);
    $("#mdView").modal("show");
  });
}

function fntEdit(id) {
  let ajaxUrl = base_url + "Roles/buscar/" + id;
  $("#titleModal").html("Actualizar Rol");
  $(".modal-header").removeClass("headerRegister");
  $(".modal-header").addClass("headerUpdate");
  $("#btnActionForm").removeClass("btn-primary");
  $("#btnActionForm").addClass("btn-info");
  $("#btnText").html("Actualizar");
  $("#modalRol").modal("show");
  //
  $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    if (objData.status) {
      $("#txtIdrol").val(objData.data.idrol);
      $("#txtRol_nombre").val(objData.data.rol_nombre);
      $("#txtRol_cod").val(objData.data.rol_cod);
      $("#txtRol_descripcion").val(objData.data.rol_descripcion);
      $("#txtRol_estado").val(objData.data.rol_estado);
      $("#txtRol_fecha").val(objData.data.rol_fecha);
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
    title: "Eliminar Rol",
    text: "¿Realmente quiere eliminar Rol?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      let ajaxUrl = base_url + "/Roles/eliminar/" + idp;
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
  $("#titleModal").html("Nuevo Rol");
  //document.querySelector("#formRol").reset();
  $("#formRol").trigger("reset");
  $("#modalRol").modal("show");
}
