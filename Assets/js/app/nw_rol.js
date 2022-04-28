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
      
      { data: "rol_estado",class:"text-center" },
      
      { data: "options" ,class:"text-end"},
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
  });

  $("#formRol").submit(function (event) {
    event.preventDefault();
    let form = $("#formRol").serialize();
    $('button[type="submit"]').attr("disabled", true);
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "Roles/acc";
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      // if (objData.status) {
      Swal.fire(objData.title, objData.text, objData.icon);
      tb.api().ajax.reload();
      // }
      divLoading.css("display", "none");
      $('button[type="submit"]').attr("disabled", false);
      $("#formRol").trigger("reset");
      $("#modalRol").modal("hide");
    });
  });
});

function fntView(id) {
  let ajaxUrl = base_url + "Roles/buscar/" + id;
  $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    if (objData.status) {
      $("#idrol").html(objData.data.idrol);
      $("#rol_nombre").html(objData.data.rol_nombre);
      $("#rol_cod").html(objData.data.rol_cod);
      $("#rol_descripcion").html(objData.data.rol_descripcion);
      $("#rol_estado").html(objData.data.rol_estado);
      $("#rol_fecha").html(objData.data.rol_fecha);

      $("#mdView").modal("show");
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
      $("#idIdrol").val(objData.data.idrol);
      $("#txtIdrol").val(objData.data.idrol);
      $("#txtRol_nombre").val(objData.data.rol_nombre);
      $("#txtRol_cod").val(objData.data.rol_cod);
      $("#txtRol_descripcion").val(objData.data.rol_descripcion);
      $("#txtRol_estado").val(objData.data.rol_estado);
      $("#txtRol_fecha").val(objData.data.rol_fecha);
      $("._hiden").removeClass("d-none");
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
  $("#txtRol_nombre").focus();
  $('button[type="submit"]').attr("disabled", false);
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
