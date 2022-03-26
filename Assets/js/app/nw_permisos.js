let divLoading = $("#divLoading");
let tb;

$(document).ready(function () {
    tb = $("#sis_permisos").dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
            url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
        },
        ajax: {
        url: base_url + "permisos/listar",
        method: "POST",
        dataSrc: "",
        },
        columns: [{data: "idpermisos"},{data: "idrol"},{data: "idsubmenu"},{data: "perm_r"},{data: "perm_w"},{data: "perm_u"},{data: "perm_d"},{data: "options",}],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
    });
    

    $("#formpermisos").submit(function (event) {
        event.preventDefault();
        let idpermisos = $("#txtIdpermisos").val();let idrol = $("#txtIdrol").val();let idsubmenu = $("#txtIdsubmenu").val();let perm_r = $("#txtPerm_r").val();let perm_w = $("#txtPerm_w").val();let perm_u = $("#txtPerm_u").val();let perm_d = $("#txtPerm_d").val();
        if (idrol == "") {
        Swal.fire("Atención", "El ´idrol´ es necesario.", "warning");
        return false;
        }
        divLoading.css("display", "flex");
        let ajaxUrl = base_url + "permisos/acc";
        $.post(ajaxUrl,{ idpermisos:idpermisos,idrol:idrol,idsubmenu:idsubmenu,perm_r:perm_r,perm_w:perm_w,perm_u:perm_u,perm_d:perm_d, },function (data) {
            let objData = JSON.parse(data);
            $("#modalpermisos").modal("hide");
            if (objData.status) {
            Swal.fire("permisos", objData.text, "success");
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
    let ajaxUrl = base_url + "permisos/buscar/" + id;
    $.get(ajaxUrl, function (data) {
        let objData = JSON.parse(data);
        $("#idpermisos").html(objData.data.idpermisos);$("#idrol").html(objData.data.idrol);$("#idsubmenu").html(objData.data.idsubmenu);$("#perm_r").html(objData.data.perm_r);$("#perm_w").html(objData.data.perm_w);$("#perm_u").html(objData.data.perm_u);$("#perm_d").html(objData.data.perm_d);
        $("#mdView").modal("show");
    });
}

function fntEdit(id) {
    let ajaxUrl = base_url + "permisos/buscar/" + id;
    $("#titleModal").html("Actualizar permisos");
    $(".modal-header").removeClass("headerRegister");
    $(".modal-header").addClass("headerUpdate");
    $("#btnActionForm").removeClass("btn-primary");
    $("#btnActionForm").addClass("btn-info");
    $("#btnText").html("Actualizar");
    $("#modalpermisos").modal("show");
    //
    $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    if (objData.status) {
        $("#txtIdpermisos").val(objData.data.idpermisos);$("#txtIdrol").val(objData.data.idrol);$("#txtIdsubmenu").val(objData.data.idsubmenu);$("#txtPerm_r").val(objData.data.perm_r);$("#txtPerm_w").val(objData.data.perm_w);$("#txtPerm_u").val(objData.data.perm_u);$("#txtPerm_d").val(objData.data.perm_d);
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
    title: "Eliminar permisos",
    text: "¿Realmente quiere eliminar permisos?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      let ajaxUrl = base_url + "/permisos/eliminar/"+idp;
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
    $("#titleModal").html("Nuevo permisos");
    //document.querySelector("#formpermisos").reset();
    $("#formpermisos").trigger("reset");
    $("#modalpermisos").modal("show");
}