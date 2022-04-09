let divLoading = $("#divLoading");
$(document).ready(function () {
  if ($("#txtdni").val() != "" && $("#txtemail").val() != "") {
    $("#btnActionForm").attr("disabled", false);
  }

  $("#txtdni").keyup(function () {
    let dni = $("#txtdni").val();
    if ($("#txtdni").val().length == 8) {
      let ajaxUrl = base_url + "web/consultar/" + dni;
      $("#txtdni").attr("disabled", true);
      $("#btnActionForm").attr("disabled", true);
      divLoading.css("display", "flex");
      $.get(ajaxUrl, function (data) {
        let objData = JSON.parse(data);
        console.log(objData);
        if (objData.success) {
          $("#txtnombre").val(objData.data.nombre_completo);
          $(".div_nom").show("slow");
          $("#txtdni").val(dni);
          $("#txtdni").attr("disabled", false);
          $("#btnActionForm").attr("disabled", false);
          $("#txtemail").focus();
        } else {
          Swal.fire({
            title: objData.message,
            icon: "warning",
            confirmButtonText: "ok",
          });
          $("#txtdni").val(dni);
          $("#txtdni").attr("disabled", false);
        }
        divLoading.css("display", "none");
      });
    }
  });

  $("#regusu").submit(function (event) {
    event.preventDefault();
    let form = $("#regusu").serialize();
    let ajaxUrl = base_url + "web/registrar";
    divLoading.css("display", "flex");
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      $("#exampleModal2").modal("hide");
      if (objData.status) {
        Swal.fire(objData.title, objData.text, objData.icon);
      } else {
        Swal.fire(objData.title, objData.text, objData.icon);
      }
      divLoading.css("display", "none");
      $("#regusu").trigger("reset");
    });
  });

  $("#usulog").submit(function (event) {
    event.preventDefault();
    let form = $("#usulog").serialize();
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "web/login";
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData.status) {
        Swal.fire({
          title: objData.title,
          icon: objData.icon,
          text: objData.text,
          // toast: true,
          // position: "top-end",
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            window.location.href = base_url + "web/password";
          }
        });
      } else {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
      divLoading.css("display", "none");
      // $("#usulog").trigger("reset");
    });
  });

  $("#usureset").submit(function (event) {
    event.preventDefault();
    let form = $("#usureset").serialize();
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "web/recover";
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      $("#exampleModal1").modal("hide");
      if (objData.status) {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          showCloseButton: false,
          confirmButtonText: "Recuperar contraseña",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = objData.url;
          }
        });
      } else {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          showCancelButton: false,
          cancelButtonText: "Ok, Cerrar",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = objData.url;
          }
        });
      }
      $("#usulog").trigger("reset");
      $("#usureset").trigger("reset");
      divLoading.css("display", "none");
      // $("#usulog").trigger("reset");
    });
  });
});

function flip() {
  $("#usulog").hide("swing");
  $("#usureset").show("slow");
}

function flop() {
  $("#usureset").hide("swing");
  $("#usulog").show("slow");
}
