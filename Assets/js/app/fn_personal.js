let tb;
$(document).ready(function () {
  tb = $("#tb").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: "" + base_url + "personal/lst",
      method: "POST",
      dataSrc: "",
    },
    columns: [
      { data: "nmr" },
      { data: "dni" },
      { data: "nombre" },
      { data: "estado" },
      { data: "opciones" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    // order: [[0, "asc"]],
  });
  $("#form").submit(function (e) {
    e.preventDefault();

    let form = $("#form").serialize();
    $("#divLoading").css("display", "flex");
    let ajaxUrl = base_url + "personal/acc";

    $.post(ajaxUrl, form, function (data, textStatus, jqXHR) {
      let objData = JSON.parse(data);
      if (textStatus == "success" && jqXHR.readyState == 4) {
        if (objData.status) {
          Swal.fire({
            title: objData.title,
            text: objData.text,
            icon: objData.icon,
            confirmButtonColor: "#007065",
            confirmButtonText: "ok",
          }).then((result) => {
            $("#form").trigger("reset");
            tb.api().ajax.reload();
          });
        } else {
          Swal.fire({
            title: objData.title,
            text: objData.text,
            icon: objData.icon,
            confirmButtonColor: "#007065",
            confirmButtonText: "ok",
          });
        }
      }
      $("#divLoading").css("display", "none");
    });
  });
});

function buscarDni(ths, e) {
  e.preventDefault();
  var btn = $(ths);
  btn.html(
    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
  );
  btn.attr("disabled", true);
  $("#txtnombre").val("");
  var dni = $("#txtsearch").val();
  let ajaxUrl = base_url + "web/consultar/" + dni;
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    if (textStatus == "success" && jqXHR.readyState == 4) {
      var json = jQuery.parseJSON(data);
      if (json.success == true) {
        $("#txtnombre").val(json.data.nombre_completo);
        $("#txtcel").focus();
      }
    }
    btn.html('<i class="fas fa-search"></i>');
    btn.attr("disabled", false);
  });
}

// function fn_submit(e) {
//   var form = $(e);
//   var data = new FormData(form[0]);

//   if (form[0].checkValidity() === false) {
//     form[0].classList.add("was-validated");
//   } else {
//     var btn = form.find('[type="submit"]');
//     btn.removeClass("btn-primary");
//     btn.addClass("btn-danger");
//     btn.html(
//       '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
//     );

//     var _url = form.attr("data-action");
//     $.ajax({
//       type: "POST",
//       url: _url,
//       data: data,
//       processData: false,
//       contentType: false,
//       success: function (response) {
//         var method = form.attr("data-method");
//         var json = jQuery.parseJSON(response);
//         btn.html("Guardar");
//         btn.removeClass("btn-danger");
//         btn.addClass("btn-primary");

//         if (method == "edi") {
//           if (json.type == "success") {
//             table.ajax.reload(null, false);
//             $("#modalForm").modal("hide");
//           }
//           swal({
//             title: json.text,
//             icon: json.type,
//             button: {
//               text: "Cerrar",
//               className: "btn btn-secondary btn-sm",
//               closeModal: true,
//             },
//           });
//         }
//         if (method == "add") {
//           table.ajax.reload();
//           form.trigger("reset");

//           swal({
//             title: json.text,
//             icon: json.type,
//             button: {
//               text: "Cerrar",
//               className: "btn btn-secondary btn-sm",
//               closeModal: true,
//             },
//           });
//         }
//       },
//     });
//   }
//   return false;
// }

function fntEdit(nmr) {
  let ajaxUrl = base_url + "personal/persona/" + nmr;
  $("#titleModal").html("Actualizar");
  $("#item").val("");
  $(".modal-header").removeClass("headerRegister").addClass("headerUpdate");
  $("#btnActionForm").removeClass("btn-primary").addClass("btn-info");
  $("#btnText").html("Actualizar");
  $("#addModal").modal("show");
  //
  $.get(ajaxUrl, function (data) {
    let objData = JSON.parse(data);
    console.log(objData);
    if (objData.status) {
      $("#item").val(objData.data.nmr);
      $("#txtsearch").val(objData.data.dni);
      $("#txtnombre").val(objData.data.nombre);
      $("#txtcel").val(objData.data.cel);
      $("#txtdir").val(objData.data.direc);
      $("#txtestado").val(objData.data.estado);
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

function fntDel(id) {
  Swal.fire({
    title: "Estas seguro?",
    text: "¿Realmente quiere eliminar el registro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      let ajaxUrl = base_url + "personal/eliminar/" + id;
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
