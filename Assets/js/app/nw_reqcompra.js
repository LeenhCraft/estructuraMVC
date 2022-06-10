let divLoading = $("#divLoading");
let tb;
$(document).ready(function () {
  tb = $("#tblibro").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
    },
    ajax: {
      url: base_url + "reqcompra/listar",
      method: "GET",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "isbn" },
      { data: "titulo" },
      { data: "autor" },
      { data: "stock" },
      { data: "options" },
    ],
    responsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[4, "asc"]],
  });

  load_cod($(".cod_ficha")); //esto genera un codigo desde el backend

  $("#formpermisos").submit(function (event) {
    event.preventDefault();
    let form = $("#formpermisos").serialize();
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "permisos/acc";
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
      divLoading.css("display", "none");
    });
  });
});

function agregarDetalle(id, isbn, titulo, autor, stock) {
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

function load_cod(e) {
  $(e).html(
    `<div class="spinner-border spinner-border-sm fw- text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`
  );
  let ajaxUrl = base_url + "reqcompra/op3";
  $.get(ajaxUrl, function (data, textStatus) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        $(e).removeClass("text-center").html(objData["data"]); // aqui le dices que te muestre el codigo en la vista
        $("#ficha_cod").val(objData["data"]); // aqui le das el valor del codigo al campo oculto, ahora cuando le des al boton de generar este campo oculto contendra el codigo y te lo enviara al backend
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

function gen_req(e) {
  let form = $(e).serialize();
  let ajaxUrl = base_url + "reqcompra/registrar";
  $.post(ajaxUrl, form, function (data, textStatus, jqXHR) {});
  return false; //pongo false para que no recarge, es como el preventDefault
}
