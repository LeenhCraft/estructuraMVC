let divLoading = $("#divLoading");
let tb;

$(document).ready(function () {
    tb = $("#sis_menus").dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
            url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
        },
        ajax: {
        url: base_url + "menus/listar",
        method: "POST",
        dataSrc: "",
        },
        columns: [{data: "idmenu"},{data: "men_nombre"},{data: "men_icono"},{data: "men_url_si"},{data: "men_url"},{data: "men_controlador"},{data: "men_orden"},{data: "men_visible"},{data: "men_fecha"},{data: "options",}],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
    });
    

    $("#formmenus").submit(function (event) {
        event.preventDefault();
        let idmenu = $("#txtIdmenu").val();let men_nombre = $("#txtMen_nombre").val();let men_icono = $("#txtMen_icono").val();let men_url_si = $("#txtMen_url_si").val();let men_url = $("#txtMen_url").val();let men_controlador = $("#txtMen_controlador").val();let men_orden = $("#txtMen_orden").val();let men_visible = $("#txtMen_visible").val();let men_fecha = $("#txtMen_fecha").val();
        if (men_nombre == "") {
        Swal.fire("Atención", "El ´men_nombre´ es necesario.", "warning");
        return false;
        }
        divLoading.css("display", "flex");
        let ajaxUrl = base_url + "menus/acc";
        $.post(ajaxUrl,{ idmenu:idmenu,men_nombre:men_nombre,men_icono:men_icono,men_url_si:men_url_si,men_url:men_url,men_controlador:men_controlador,men_orden:men_orden,men_visible:men_visible,men_fecha:men_fecha, },function (data) {
            let objData = JSON.parse(data);
            $("#modalmenus").modal("hide");
            if (objData.status) {
            Swal.fire("menus", objData.text, "success");
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
    let ajaxUrl = base_url + "menus/buscar/" + id;
    $.get(ajaxUrl, function (data) {
        let objData = JSON.parse(data);
        $("#idmenu").html(objData.data.idmenu);$("#men_nombre").html(objData.data.men_nombre);$("#men_icono").html(objData.data.men_icono);$("#men_url_si").html(objData.data.men_url_si);$("#men_url").html(objData.data.men_url);$("#men_controlador").html(objData.data.men_controlador);$("#men_orden").html(objData.data.men_orden);$("#men_visible").html(objData.data.men_visible);$("#men_fecha").html(objData.data.men_fecha);
        $("#mdView").modal("show");
    });
}

function fntEdit(id) {
    let ajaxUrl = base_url + "menus/buscar/" + id;
    $("#titleModal").html("Actualizar menus");
    $(".modal-header").removeClass("headerRegister");
    $(".modal-header").addClass("headerUpdate");
    $("#btnActionForm").removeClass("btn-primary");
    $("#btnActionForm").addClass("btn-info");
    $("#btnText").html("Actualizar");
    $("#modalmenus").modal("show");
    //
    $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    if (objData.status) {
        $("#txtIdmenu").val(objData.data.idmenu);$("#txtMen_nombre").val(objData.data.men_nombre);$("#txtMen_icono").val(objData.data.men_icono);$("#txtMen_url_si").val(objData.data.men_url_si);$("#txtMen_url").val(objData.data.men_url);$("#txtMen_controlador").val(objData.data.men_controlador);$("#txtMen_orden").val(objData.data.men_orden);$("#txtMen_visible").val(objData.data.men_visible);$("#txtMen_fecha").val(objData.data.men_fecha);
    }else{
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
    title: "Eliminar menus",
    text: "¿Realmente quiere eliminar menus?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      let ajaxUrl = base_url + "/menus/eliminar/"+idp;
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
    $("#titleModal").html("Nuevo menus");
    //document.querySelector("#formmenus").reset();
    $("#formmenus").trigger("reset");
    $("#modalmenus").modal("show");
}