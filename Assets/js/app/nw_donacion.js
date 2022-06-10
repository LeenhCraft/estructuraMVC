$(document).ready(function () {
  // $("#donante").select2({
  //   theme: "bootstrap4",
  //   width: $(this).data("width")
  //     ? $(this).data("width")
  //     : $(this).hasClass("w-100")
  //     ? "100%"
  //     : "style",
  //   // placeholder: "Donante",
  //   // allowClear: Boolean($(this).data("allow-clear")),
  //   // closeOnSelect: !$(this).attr("multiple"),
  // });
  // select_libros($(".nav-link.active"));
  load_cod($(".cod_ficha"));
});

function lstlibros(param) {
  let ajaxUrl = base_url + "donacion/lstlibros";
  $.get(ajaxUrl, function (data) {
    $("#libros").html(data);
  });
}

function agregarDetalle(e) {
  let btn = $(e);
  if (btn.attr("lnh-op") == "new") {
    let form = $(".frm_new_lib").serialize();
    let ajaxUrl = base_url + "donacion/newbook";
    $.post(ajaxUrl, form, function (data, textStatus, jqXHR) {
      let objData = JSON.parse(data);
      Toast.fire({
        icon: objData.icon,
        title: objData.text,
      });
      if (objData.status) {
        let buton = $("#btnInsert");
        buton
          .attr("data-lib", objData.data)
          .attr("data-title", $("#titulo_lib").val())
          .removeAttr("lnh-op")
          .trigger("click");
      }
    });
  } else {
    var libro_id = btn.attr("data-lib") != null ? btn.attr("data-lib") : "";
    var libro_titulo =
      btn.attr("data-title") != null ? btn.attr("data-title") : "";
    var cantidad = $("#stock_lib").val();
    var tabladet = $("#tabledetalle tbody");
    if (libro_id != "") {
      if (cantidad != "" && cantidad > 0) {
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
                    <td><input class="form-control form-control-sm cant text-center" name="cant[]" type="text" value="${cantidad}"></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" onclick="mostrarInformacionDetalle(ths, evnt, ${libro_id})" class="btn btn-sm py-0 btn-warning d-none">
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
        // $("#libros").val(null).trigger("change");
        // $("#detll3").val(1);
        btn.removeAttr("data-lib").removeAttr("data-title");
        limpiar($(".btn_cod"));
      } else {
        Toast.fire({
          icon: "warning",
          title: "Ingrese una cantidad valida!!",
        });
      }
    } else {
      Toast.fire({
        icon: "warning",
        title: "Seleccione un libro!!",
      });
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

function load_cod(e) {
  $(e).html(
    `<div class="spinner-border spinner-border-sm fw- text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  let ajaxUrl = base_url + "donacion/ajax/op3";
  $.get(ajaxUrl, function (data, textStatus) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        $(e).removeClass("text-center").html(objData["data"]);
        $("#cod_ficha").val(objData["data"]);
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

function bsc_pro(e) {
  let btn = $("#button-addon2");
  let txt = btn.html();
  let param = $("#txtdoc").val();
  let ajaxUrl = base_url + "donacion/ajax/proveedor";
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $.get(ajaxUrl, { a: param }, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      $("#donante").val(objData.data.idprodon);
      $(".lbldoc").html(objData.data.doc);
      $("#lblnombre")
        .html(objData.data.nombre)
        .addClass("text-primary fw-bold");
      $("#lbldirec").html(
        objData.data.pro_direccion == null
          ? "sin direccion"
          : objData.data.pro_direccion
      );
      $("#lblcel").html(
        objData.data.pro_nmr_celular == null
          ? "sin celular"
          : objData.data.pro_nmr_celular
      );
      $("#lblemail").html(objData.data.pro_email);
      // $("#imgFoto").attr("src", objData.data.usu_foto);

      btn.html(txt);
      $(".div_hidden").show("slow");
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $(".lbldoc").html("");
      $("#lbldirec").html("");
      $("#lblcel").html("");
      $("#lblemail").html("");
      $("#imgFoto").attr("src", "https://via.placeholder.com/180x270");
      $("#txtdoc").focus();
      btn.html(txt);
      $(".div_hidden").hide("slow");
    }
  });
  return false;
}

function bsc_libro(e) {
  let btn = $(".btn_cod");
  let txt = btn.html();
  let param = $("#cod_isbn").val();
  let ajaxUrl = base_url + "donacion/libro/" + param;
  let buton = $("#btnInsert");
  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      $("#cod_isbn").attr("readonly", true);
      $("#titulo_lib").val(objData.data.art_nombre).attr("readonly", true);
      $("#Edic_lib").val(objData.data.art_estado).attr("readonly", true);
      $("#isbn_10").val(objData.data.art_isbn).attr("readonly", true);
      $("#det_lib").val(objData.data.art_descri).attr("readonly", true);
      $("#edit_lib").attr("disabled", true);
      $("#Edic_lib").attr("readonly", true);
      $("#Form_lib").attr("disabled", true);
      $("#autor_lib").attr("disabled", true);
      $("#cat_lib").attr("readonly", true);
      $("#pais_lib").attr("disabled", true);
      $("#isbn_13").val("sin isbn de 13 digitos").attr("readonly", true);
      btn
        .removeClass("btn-outline-primary")
        .addClass("btn-danger")
        .html(`<i class='bx bx-trash'></i>`)
        .attr("type", "button")
        .attr("onclick", "limpiar(this)");
      buton
        .attr("data-lib", objData.data.idarticulo)
        .attr("data-title", objData.data.art_nombre)
        .removeAttr("lnh-op");
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $(".lbldoc").html("");
      $("#lbldirec").html("");
      $("#lblcel").html("");
      $("#lblemail").html("");
      $("#imgFoto").attr("src", "https://via.placeholder.com/180x270");
      $("#txtdoc").focus();
      btn.html(txt);
      $(".div_hidden").hide("slow");
    }
  });
  return false;
}

function limpiar(e) {
  let btn = $(e);
  let buton = $("#btnInsert");
  $("#cod_isbn").attr("readonly", false).val("");
  $("#titulo_lib").val("").attr("readonly", false);
  $("#Edic_lib").val("").attr("readonly", false);
  $("#isbn_10").val("").attr("readonly", false);
  $("#det_lib").val("").attr("readonly", false);
  $("#stock_lib").val("");
  $("#edit_lib").attr("disabled", false);
  $("#Edic_lib").attr("readonly", false);
  $("#Form_lib").attr("disabled", false);
  $("#autor_lib").attr("disabled", false);
  $("#cat_lib").val("").attr("readonly", false);
  $("#pais_lib").attr("disabled", false);
  $("#isbn_13").val("").attr("readonly", false);

  btn
    .addClass("btn-outline-primary")
    .removeClass("btn-danger")
    .html(`buscar`)
    .removeAttr("onclick")
    .attr("type", "submit");
  buton.removeAttr("data-lib").removeAttr("data-title").attr("lnh-op", "new");
}

function fn_submit_form(e) {
  let form = $(e);
  let data = new FormData(form[0]);
  let _url = base_url + "donacion/registrar";
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
        $("#donante").val("");
        $("#cod_ficha").val("");
        $("#tabledetalle tbody").html("");
        $(".div_hidden").hide("slow");
        $("#txtdoc").val("");
        load_cod($(".cod_ficha"));
      }
    },
  });
  return false;
}
