<section class="login_part padding_topp">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="login_part_text text-center">
                    <div class="login_part_text_iner">
                        <h2>¿Eres Nuevo?</h2>
                        <p>No te pierdas nuestras novedades, registrate y reserva tu libro que tanto deseas.</p>
                        <a onclick="modalRegistrarCuenta(this, event)" href="#" class="btn_3">Crear mi cuenta</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="login_part_form">
                    <div class="login_part_form_iner">
                        <h3>Bienvenido Nuevamente!</h3>
                        <form id="usulog" class="row contact_form" novalidate="novalidate">
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="txtusu" name="txtusu" value="" placeholder="Username">
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="password" class="form-control" id="txtpas" name="txtpas" value="" placeholder="Password">
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="creat_account d-flex align-items-center">
                                    <input type="checkbox" id="f-option" name="selector">
                                    <label for="f-option">Remember me</label>
                                </div>
                                <button type="submit" value="submit" class="btn_3">
                                    log in
                                </button>
                                <a class="lost_pass" onclick="flip()" href="#">Olvide mi contraseña</a>
                            </div>
                        </form>
                        <form id="usureset" class="row contact_form fmr_none" style="display: none;">
                            <div class="form-group col-md-12 ft-b text-left">
                                <label for="txtusu">Correo</label>
                                <input type="email" class="form-control" id="txtusu" name="txtusu" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" class="btn_3">Recuperar</button>
                                <a class="lost_pass" href="#" onclick="flop()"><i class="fa fa-angle-left fa-fw"></i> Iniciar sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("#usulog").submit(function(event) {
            event.preventDefault();
            let form = $("#usulog").serialize();
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
        $("#usureset").submit(function(event) {
            event.preventDefault();
            let form = $("#usureset").serialize();
            divLoading.css("display", "flex");
            let ajaxUrl = base_url + "web/recover";
            $.post(ajaxUrl, form, function(data) {
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

    function modalRegistrarCuenta(ths, evnt) {
        var modl = $('#exampleModal');
        var resp = modl.find('.modal-body');
        var title = modl.find('.modal-title');
        resp.html('<div class="text-center my-5"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
        title.text('');

        $.get('<?= base_url() . 'me/register' ?>', function(data, textStatus, jqXHR) {
            if (textStatus == 'success') {
                modl.find('.login-content').addClass('modal-lg');
                // title.text('Registrarme');
                resp.html(data);
                console.log(resp);
            }
        });

    }
</script>