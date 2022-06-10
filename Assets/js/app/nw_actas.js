let tb;
$(document).ready(function () {
  load_cod($(".cod_ficha"));
});

function load_cod(e) {
  $(e).html(
    `<div class="spinner-border spinner-border-sm fw- text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  let ajaxUrl = base_url + "actas/ajax/op3";
  $.get(ajaxUrl, function (data, textStatus) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        $(e).removeClass("text-center").html(objData["data"]);
        $("#codActa").val(objData["data"]);
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

function bsc_donacion(e) {
  let btn = $(e).find("button");
  let input = $(e).find("input");
  let cod_ficha = $("#txtCod").val();
  let ajaxUrl = base_url + "actas/buscar/" + cod_ficha;
  $("#spinner").css("display", "flex").css("right", "0");
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData.status) {
        // $("#lstDonaciones").dataTable().fnDestroy();
        // $("#lstDonaciones tbody").html(objData["data"]);
        // lrtTabler();
        if (objData.data.usu) {
          $(".lblname").html(objData.data.usu.name);
          $(".lbldoc").html(objData.data.usu.doc);
          $(".lbldir").html(objData.data.usu.pro_direccion);
          $(".lbltper").html(objData.data.usu.tpro_nombre);
          $(".lblcel").html(objData.data.usu.pro_nmr_celular);
          $(".lblemail").html(objData.data.usu.pro_email);
          $(".div_hidden").show("slow");
          input.attr("disabled", true);
          btn
            .removeClass("btn-outline-secondary")
            .addClass("btn-danger")
            .html(`<i class='bx bx-trash'></i>`)
            .attr("type", "button")
            .attr("onclick", "limpiar()");
        } else {
          // $(".div_hidden").hide("slow");
          limpiar();
        }
        $("#lstDonaciones tbody").html(objData.data.fichas);
      } else {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
    }
    $("#spinner").css("display", "none");
  });
  return false;
}

// $("#exampleModal")
//   .on("shown.bs.modal", function (event) {
//     var mdl = $(event.relatedTarget);
//     var ths = $(this);
//     var resp = ths.find(".modal-body");
//     resp.html(
//       '<div class="text-center my-5"><div class="spinner-border spinner-border-lg text-primary" style="width: 4rem; height: 4rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>'
//     );
//     $.get(mdl.data("url"), function (data, textStatus, jqXHR) {
//       if (textStatus == "success") {
//         // ths.find(".modal-title").text(mdl.data("title"));
//         resp.html(data);
//       }
//     });
//   })
//   .on("hidden.bs.modal", function (event) {
//     var mbody = $(this).find(".modal-body");
//     mbody.empty();
//     $(this).find(".login-content").removeClass("modal-lg");
//     // $(this).find(".modal-title").text("");
//     mbody.html(
//       '<div class="text-center my-5"><div class="spinner-border spinner-border-lg text-primary" style="width: 4rem; height: 4rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>'
//     );
//   });

function lrtTabler() {
  tb = $("#lstDonaciones").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "actas/listar",
      method: "POST",
      dataSrc: "",
    },
    columns: [
      { data: "nmr" },
      { data: "rol" },
      { data: "menu" },
      { data: "submenu" },
      { data: "r" },
      { data: "w" },
      { data: "u" },
      { data: "d" },
      { data: "options" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    // order: [[0, "desc"]],
  });
}

function limpiar() {
  $("#txtCod").attr("disabled", false).val("");
  $("#button-addon2")
    .addClass("btn-outline-secondary")
    .removeClass("btn-danger")
    .html(`<i class='bx bx-search-alt-2'></i>`)
    .removeAttr("onclick")
    .attr("type", "submit");
  $(".lblname").html("Sin datos");
  $(".lbldoc").html("");
  $(".lbldir").html("");
  $(".lbltper").html("");
  $(".lblcel").html("");
  $(".lblemail").html("");
  $(".div_hidden").hide("slow");
  $(".div_detDona").hide("fast");
  $("#lstDonaciones tbody").html(
    '<tr><td colspan="9" class="text-center">Sin datos</td></tr>'
  );
}
function ver_det(param) {
  $("#idDona").val(param);
  let url = base_url + "actas/detalle";
  $.post(url, { cod: param }, function (data, textStatus, jqXHR) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData.status) {
        $("#detDonacion tbody").html(objData.data);
        $(".div_detDona").show("fast");
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

function fn_submit_form(e) {
  let form = $(e);
  let data = new FormData(form[0]);
  let _url = base_url + "actas/registrar";
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
        $("#idDona").val("");
        $("#codActa").val("");
        $("#detDonacion tbody").html("");
        // $(".div_hidden").hide("slow");
        // $("#txtdoc").val("");
        load_cod($(".cod_ficha"));
        $("#inpDon").trigger("submit");
      }
    },
  });
  return false;
}
