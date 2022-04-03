$(document).ready(function () {
  let divLoading = $("#divLoading");
  $("#frm").submit(function (event) {
    event.preventDefault();
    let ajaxUrl = base_url + "Primeraves/reset";
    let form = $(this).serialize();
    console.log(form);
    divLoading.css("display", "flex");
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData["status"]) {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
        // .then((result) => {
        //   if (result.isConfirmed) {
        //     window.location.reload();
        //   }
        // });
      } else {
        Swal.fire({
          title: "Advertencia!",
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
      divLoading.css("display", "none");
      $("#frm").trigger("reset");
    });
  });
});

function verpass(e, input) {
  let selector = "#" + input;
  let elem = $(selector);

  if (elem.attr("type") == "password") {
    elem.attr("type", "text");
  } else {
    elem.attr("type", "password");
  }
}

function ocultarbarra(e) {
  let selector = "#" + e;
  let elem = $(selector);
  elem.hide("slow");
}

function validarfuerza(e, a) {
  let elem = $(e).val();
  let fuerza = 0;
  if (elem == "") {
    fuerza = 0;
  }
  if (elem.length >= 6 && elem.length <= 9) {
    fuerza += 10;
  } else if (elem.length > 9) {
    fuerza += 25;
  }
  if (elem.length >= 7 && elem.match(/[a-z]+/)) {
    fuerza += 15;
  }

  if (elem.length >= 8 && elem.match(/[A-Z]+/)) {
    fuerza += 20;
  }

  if (elem.length >= 9 && elem.match(/[@#$%&;*]/)) {
    fuerza += 25;
  }

  if (elem.match(/([0-9]+).*\1{1}/)) {
    fuerza += -25;
  }
  mostrarForca(fuerza, a);
}

function mostrarForca(forca, a) {
  let selector = "#" + a;
  let elem = $(selector);
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

function verAyuda(elem) {
  let selector = "#" + elem;
  let div = $(selector);
  div.show("swing");
}
