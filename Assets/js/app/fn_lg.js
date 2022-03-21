$(document).ready(function () {
  let divLoading = $("#divLoading");
  $('[data-toggle="tooltip"]').tooltip({
    template:
      '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
  });

  $(".fa-circle-info").tooltip();
  $("#frmlogin").submit(function (event) {
    event.preventDefault();
    let ajaxUrl = base_url + "/login/loginUser";
    var form = $(this).serialize();
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        Swal.fire({
          title: "Excelente!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
        window.location = base_url + "dashboard";
      } else {
        Swal.fire({
          title: "Advertencia!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
    });
  });

  $("#frmreset").submit(function (event) {
    event.preventDefault();
    let ajaxUrl = base_url + "/login/resetPass";
    var form = $(this).serialize();
    divLoading.css("display", "flex");
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        Swal.fire({
          title: "Excelente!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      } else {
        Swal.fire({
          title: "Advertencia!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
      divLoading.css("display", "none");
      $("#frmreset").trigger("reset");
    });
  });

  $("#formCambiarPass").submit(function (event) {
    event.preventDefault();
    var ajaxUrl = base_url + '/Login/setPassword';
    var form = $(this).serialize();
    divLoading.css("display", "flex");
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        Swal.fire({
          title: "Excelente!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = base_url;
          }
        });
      } else {
        Swal.fire({
          title: "Advertencia!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
      divLoading.css("display", "none");
      $("#frmreset").trigger("reset");
    });
  });

  $('.login-content [data-toggle="flip"]').click(function () {
    $(".login-box").toggleClass("flipped");
    return false;
  });
});

function verpass(e, input) {
  var selector = "#" + input;
  var elem = $(selector);
  console.log(elem);

  if (elem.attr("type") == "password") {
    elem.attr("type", "text");
  } else {
    elem.attr("type", "password");
  }
}

function ocultarbarra(e) {
  var selector = "#" + e;
  var elem = $(selector);
  elem.hide("slow");
}

function validarfuerza(e, a) {
  var elem = $(e).val();
  var forca = 5;

  if (elem == "") {
    forca = 0;
  }
  if (elem.length >= 4 && elem.length <= 7) {
    forca += 10;
  } else if (elem.length > 7) {
    forca += 25;
  }

  if (elem.length >= 5 && elem.match(/[a-z]+/)) {
    forca += 10;
  }

  if (elem.length >= 6 && elem.match(/[A-Z]+/)) {
    forca += 20;
  }

  if (elem.length >= 7 && elem.match(/[@#$%&;*]/)) {
    forca += 25;
  }

  if (elem.match(/([1-9]+)\1{3,}/)) {
    forca += -25;
  }
  console.log(forca);
  mostrarForca(forca, a);
}

function mostrarForca(forca, a) {
  var selector = "#" + a;
  var elem = $(selector);
  elem.show("slow");
  if (forca < 30 && forca >= 5) {
    elem.html(
      '<div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>'
    );
  } else if (forca >= 30 && forca < 50) {
    elem.html(
      '<div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>'
    );
  } else if (forca >= 50 && forca < 70) {
    elem.html(
      '<div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>'
    );
  } else if (forca > 70) {
    elem.html(
      '<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>'
    );
  } else {
    elem.html(
      '<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'
    );
  }
}
