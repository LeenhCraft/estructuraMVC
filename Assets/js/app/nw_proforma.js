let divLoading = $("#divLoading");
let tb;
$(document).ready(function () {});

//load_cod($(".cod_proforma")); //esto genera un codigo desde el backend

function bsc_proveedor(e) {
  let btn = $("#button-addon2");
  let txt = btn.html();
  let param = $("#txtCod").val();
  let ajaxUrl = base_url + "proforma/buscar/" + param;

  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    let objData = JSON.parse(data);
    if (textStatus == "success" && objData.status == true) {
      $("#lblnombre")
        .html(objData.data.pro_nombrecompleto)
        .addClass("text-primary fw-bold");
      $("#lbldni").html(objData.data.pro_dni);
      $("#lblcel").html(
        objData.data.pro_nrm_cel == null
          ? "sin celular"
          : objData.data.pro_nrm_cel
      );
      $("#lblusu").html(objData.data.pro_email);
      $(".spinner-grow").removeClass("d-none");
      $("button[disabled]").attr("disabled", false);
      btn.html(txt);
      $(".div_hidden").show("slow");
    } else {
      Swal.fire(objData.title, objData.text, objData.icon);
      $("#lblnombre").html("");
      $("#lbldni").html("");
      $("#lblcel").html("");
      $("#lblusu").html("");

      $("#txtCod").html("");
      $("#txtCod").val("");
      $("#txtCod").focus();
      $(".spinner-grow").addClass("d-none");
      btn.html(txt);
      $(".div_hidden").hide("slow");
    }
  });
  return false;
}


function agregarDetalle(id, isbn, titulo,autor, stock) {
  // var libro_id = $("#tblibro").find(":select").val();
  // var libro_titulo = $("#tblibro").find(":select").text();
  let nom = "#cant" + id;
  var cantidad = $(nom).val();
  var tabladet = $("#tabledetalle tbody");

  if (cantidad != "") {
    if (id != "") {
      var detalle = tabladet.find('tr[data-id="' + id + '"]');
      if ($(detalle).length) {
        var inputcant = detalle.find("input.cant");
        var cantotal = parseInt(cantidad) + parseInt(inputcant.val());
        inputcant.val(cantotal);
      } else {
        // requeerdas eso? name="libro[]" esto hace un array desde la vista
        tabladet.prepend(`
                <tr data-id="${id}" style="display:none">
                    <td scope="row">
                        <input type="hidden" name="libro[]" value="${id}">
                        ${titulo} 
                      

                    </td>
                    <td><input class="form-control form-control-sm cant" name="cant[]" type="text" value="${cantidad}"></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                        
                            <button type="button" onclick="eliminarDetalle(this, event, '${id}')" class="btn btn-sm py-0 btn-danger">
                              <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </td>
                </tr>`);
        $('[data-id="' + id + '"]').show("fast");
      }
      $("#tblibro").val(null).trigger("change");
      // pondre una alerta de si re agrego correctamente
      Toast.fire({
        icon: "success",
        title: "Agregado correctamente!!",
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

function bsc_requerimiento(e) {
  let btn = $("#button-addon3");
  let txt = btn.html();
  let param = $("#codReq").val();
  let ajaxUrl = base_url + "proforma/requerimientos/" + param;

  btn.html(
    `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  $("#tbrequerimiento").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: ajaxUrl,
      method: "GET",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "cod" },
      { data: "titulo" },
      { data: "cantidad" },
      { data: "options" },
    ],
    responsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    //order: [[4, "asc"]],
  });
  btn.html(txt);
  return false;
  
  
}


function fn_submit_form(e) {
  var form = $(e);
  var data = new FormData(form[0]);

  if (form[0].checkValidity() === false) {
    form[0].classList.add("was-validated");
  } else {
    var btn = form.find('[type="submit"]');
    btn.removeClass("btn-outline-primary");
    btn.addClass("btn-outline-danger");
    btn.html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
    );
    btn.attr("disabled", true);
    var _url = base_url + "prestamos/registrar";

    $.ajax({
      type: "POST",
      url: _url,
      data: data,
      processData: false,
      contentType: false,
      success: function (response) {
        var objData = JSON.parse(response);
        btn.html("Generar Servicio");
        btn.removeClass("btn-outline-danger");
        btn.addClass("btn-outline-primary");
        btn.attr("disabled", false);
        Swal.fire(objData.title, objData.text, objData.icon);
        if (objData.status == true) {
          form.trigger("reset");
          $("#idform").val("");
          $("#tabledetalle tbody").html("");
          $(".div_hidden").hide("slow");
          $("#txtCod").val("");
        }
      },
    });
  }

  return false;
}
