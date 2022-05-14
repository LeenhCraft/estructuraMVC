function bsc_lector(e) {
    let btn = $(e);
    let txt = btn.html();
    let param = $("#txtCod").val();
    let ajaxUrl = base_url + "devolucion/buscar/" + param;
    btn.html(
      `<div class="spinner-border spinner-border-sm text-light" role="status"><span class="visually-hidden">Loading...</span></div>`
    );
    $.get(ajaxUrl, function (data, textStatus, jqXHR) {
      let objData = JSON.parse(data);
      if (textStatus == "success" && objData.status == true) {
        $("#lblnombre")
          .html(objData.data.usu_nombre)
          .addClass("text-primary fw-bold");
        $("#lbldni").html(objData.data.usu_dni);
        $("#lbldirec").html(
          objData.data.usu_direc == null
            ? "sin direccion"
            : objData.data.usu_direc
        );
        $("#lblcel").html(
          objData.data.usu_cel == null ? "sin celular" : objData.data.usu_cel
        );
        $("#lblusu").html(objData.data.usu_usuario);
        $("#imgFoto").attr("src", objData.data.usu_foto);
        lstreservas(param);
        lstincidencias(param);
        lstdetalledev(param);
        $(".spinner-grow").removeClass("d-none");
        $("button[disabled]").attr("disabled", false);
        btn.html(txt);
      } else {
        Swal.fire(objData.title, objData.text, objData.icon);
        $("#lblnombre").html("");
        $("#lbldni").html("");
        $("#lbldirec").html("");
        $("#lblcel").html("");
        $("#lblusu").html("");
        $("#imgFoto").attr("src", "https://via.placeholder.com/180x200");
        $("#txtCod").html("");
        $("#txtCod").val("");
        $("#txtCod").focus();
        $(".spinner-grow").addClass("d-none");
      }
    });
  }
  
  function lstreservas(id) {
    $("#tbreservas").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
      },
      ajax: {
        url: base_url + "devolucion/lstreservas/" + id,
        method: "GET",
        dataSrc: "",
      },
      columns: [
        { data: "id" },
        { data: "cod_prestamo" },
        { data: "cantidad" },
        { data: "prestamo" },
        { data: "dprestamo" },
        { data: "estado", class: "text-center" },
        { data: "opciones", class: "text-end" },
      ],
      resonsieve: "true",
      bDestroy: true,
      iDisplayLength: 10,
    });
  }

  function fntEdit(id) {
    //let ajaxUrl = base_url + "Devolucion/act/";
    Swal.fire({
      title: "Actualizar estado",
      text: "¿Realmente quiere actualizar estado?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, update!",
      cancelButtonText: "No, update!",
    }).then((result) => {
         if (result.isConfirmed) {
        let ajaxUrl = base_url + "/Devolucion/act/";
        $.post(ajaxUrl,{dev:id}, function (data) {
          let objData = JSON.parse(data);
          if (objData.status) {
            Swal.fire({
              title: objData.title,
              text: objData.text,
              icon: objData.icon,
              confirmButtonText: "ok",
            });
            $("#tbreservas").DataTable().ajax.reload();
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
  
  function lstincidencias(param) {
    $("#tbincidencias").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
      },
      ajax: {
        url: base_url + "prestamos/lstincidentes/" + param,
        method: "GET",
        dataSrc: "",
      },
      columns: [
        { data: "idprestamo" },
        { data: "cod_prestamo" },
        { data: "motivo", class: "text-start" },
        { data: "libro" },
        { data: "fecha", class: "text-start" },
      ],
      resonsieve: "true",
      bDestroy: true,
      iDisplayLength: 10,
    });
  }
  
  /*$(document).ready(function() {
    $("#tblibros").dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
            url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
        },
        ajax: {
            url: base_url + "devolucion/lstlibros",
            method: "GET",
            dataSrc: "",
        },
        columns: [{
                data: "art_cod"
            }, {
                data: "art_nombre"
            }, {
                data: "art_isbn"
            },
            // {
            //     data: "art_cod"
            // }, {
            //     data: "art_cod"
            // }, {
            //     data: "art_cod"
            // }, {
            //     data: "art_cod"
            // },
        ],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
    });
});*/
  function lstdetalledev(param) {
    $("#tbdetalledev").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
      },
      ajax: {
        url: base_url + "devolucion/lstdetalledev/"+param,
        method: "GET",
        dataSrc: "",
      },
      columns: [
        { data: "idprestamo" },
        { data: "cod_prestamo" },
        { data: "cod_isbn" },
        { data: "titulo" },
        { data: "editorial" },
        { data: "autor" },
        { data: "edicion" },
        { data: "formato" },
      ],
      resonsieve: "true",
      bDestroy: true,
      iDisplayLength: 10,
    });
  }
  
 
  