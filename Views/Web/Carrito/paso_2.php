<div>
    <label class="h4"><b>Paso 2</b></label>
    <div class="card-body">
        <div class="returning_customer lg_user">
            <div class="check_title">
                <h2>Iniciar sesion</h2>
            </div>
            <p>Si ha comprado con nosotros anteriormente, ingrese sus datos en los cuadros a continuación. <b>Si es un usuario nuevo, haga click en crear cuenta.</b></p>
            <form id="lg_user_car" class="row contact_form mx-auto" method="post" novalidate="novalidate" onsubmit="return login_car(this)">
                <div class="col-md-6 form-group p_star mx-auto">
                    <input type="text" class="form-control rounded mb-3" id="name" name="txtusu" value="" placeholder="usuario o email">
                    <input type="password" class="form-control rounded" id="password" name="txtpas" value="" placeholder="contraseña">
                </div>
                <div class="col-md-12 form-group mx-auto text-center">
                    <button type="submit" value="submit" class="btn_3 mb-3">log in</button><br>
                    <button type="button" class="btn btn-link" onclick="$('.new_user').show('slow');$('.lg_user').hide('slow');$('#new_user_car').trigger('reset')">Crear cuenta</button>
                </div>
            </form>
        </div>
        <div class="returning_customer new_user" style="display: none;">
            <div class="check_title mb-4">
                <h2>Crear Cuenta</h2>
            </div>
            <p>Si ya tiene una cuenta con nosotros, por favor inicie sesión haciendo click en <b class="font-italic">iniciar sessión</b> para continuar con su reserva</p>
            <form id="new_user_car" class="row contact_form mx-auto" onsubmit="return new_user(this)" data-dt="car">
                <div class="form-group col-md-6 p_start mx-auto">
                    <input type="number" id="dni" name="txtdni" class="form-control mb-3" placeholder="DNI" onkeyup="return limitar(event,this.value,8)" onkeydown="return limitar(event,this.value,8)">
                    <input type="text" id="nombre" name="txtnombre" class="form-control mb-3 inp_hide" placeholder="Su nombre completo" style="display:none;">
                    <input type="email" id="email" name="txtemail" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-12 form-group mx-auto text-center">
                    <button type="submit" value="submit" class="btn_3 mb-3 btn_rg btn disabled" disabled>Crear</button><br>
                    <button type="button" class="btn btn-link" onclick="$('.lg_user').show('slow');$('.new_user').hide('slow');$('#lg_user_car').trigger('reset')">Iniciar Sesión</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#dni").keyup(function() {
                let dni = $("#dni").val();
                if ($("#dni").val().length == 8) {
                    let ajaxUrl = base_url + "web/consultar/" + dni;
                    $("#dni").attr("disabled", true);
                    $(".btn_rg").attr("disabled", true);
                    divLoading.css("display", "flex");
                    $.get(ajaxUrl, function(data) {
                        let objData = JSON.parse(data);
                        if (objData.success) {
                            $("#nombre").val(objData.data.nombre_completo);
                            $(".inp_hide").show("slow");
                            $("#dni").val(dni);
                            $("#dni").attr("disabled", false);
                            $(".btn_rg")
                                .attr("disabled", false)
                                .removeClass("btn")
                                .removeClass("disabled");
                            $("#email").focus();
                        } else {
                            Swal.fire({
                                title: objData.message,
                                icon: "warning",
                                confirmButtonText: "ok",
                            });
                            $("#dni").val(dni);
                            $("#dni").attr("disabled", false);
                        }
                        divLoading.css("display", "none");
                    });
                }
            });
        });

        function new_user(e) {
            let frm = $("#new_user_car");
            let dt = frm.attr("data-dt");
            let form = frm.serialize() + "&dt=" + dt;
            let ajaxUrl = base_url + "web/registrar";
            divLoading.css("display", "flex");
            $.post(ajaxUrl, form, function(data) {
                let objData = JSON.parse(data);
                if (objData.status) {
                    $(".ti-close").remove();
                    $(".card-body")
                        .html(
                            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>'
                        )
                        .html(objData.text);
                } else {
                    Swal.fire(objData.title, objData.text, objData.icon);
                }
                divLoading.css("display", "none");
                $("#new_user_car").trigger("reset");
            });
            return false;
        }

        function login_car(e) {
            let form = $(e).serialize();
            divLoading.css("display", "flex");
            let ajaxUrl = base_url + "web/login";
            $.post(ajaxUrl, form, function(data) {
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
                            window.location.href = base_url + "carrito";
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
            });
            return false;
        }
    </script>
</div>