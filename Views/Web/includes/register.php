<section class="login_part padding_topp">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="login_part_form">
                    <div class="login_part_form_iner">
                        <h3>Bienvenido ! <br> Por favor ingresa tus datos</h3>
                        <form id="regusu" class="row contact_form" novalidate="novalidate">
                            <div class="form-group col-md-12 ft-b text-left">
                                <label for="txtdni">DNI:</label>
                                <input type="number" class="form-control" id="txtdni" name="txtdni" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)" required>
                            </div>
                            <div class="form-group col-md-12 ft-b div_nom text-left" style="display: none;">
                                <div>
                                    <label for="txtnombre">Nombre:</label>
                                    <input type="text" class="form-control" id="txtnombre" name="txtnombre" required>
                                </div>
                            </div>
                            <div class="form-group col-md-12 ft-b text-left">
                                <label for="txtemail">Correo:</label>
                                <input type="email" class="form-control" id="txtemail" name="txtemail" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="btn_3">
                                    Registrarme
                                </button>

                                <button type="submit"  data-dismiss="modal" aria-label="Close" class="btn btn-outline-dark btn-block rounded-pill">
                                    cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="login_part_text text-center">
                    <div class="login_part_text_iner">
                        <h2>¿Ya tienes una cuenta?</h2>
                        <p>Inicia sesion y revisa nuestras nuevas novedades.</p>
                        <a onclick="modalRegistrarCuenta(this, event)" href="#" class="btn_3">Iniciar Session</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        if ($("#txtdni").val() != "" && $("#txtemail").val() != "") {
            $("#btnActionForm").attr("disabled", false);
        }

        $("#txtdni").keyup(function() {
            let dni = $("#txtdni").val();
            if ($("#txtdni").val().length == 8) {
                let ajaxUrl = base_url + "web/consultar/" + dni;
                $("#txtdni").attr("disabled", true);
                $("#btnActionForm").attr("disabled", true);
                divLoading.css("display", "flex");
                $.get(ajaxUrl, function(data) {
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
        $("#regusu").submit(function(event) {
            event.preventDefault();
            let form = $("#regusu").serialize();
            let ajaxUrl = base_url + "web/registrar";
            divLoading.css("display", "flex");
            $.post(ajaxUrl, form, function(data) {
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
    });

    function modalRegistrarCuenta(ths, evnt) {
        var modl = $('#exampleModal');
        var resp = modl.find('.modal-body');
        var title = modl.find('.modal-title');
        resp.html('<div class="text-center my-5"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
        title.text('');

        $.get('<?= base_url() . 'me/login' ?>', function(data, textStatus, jqXHR) {
            if (textStatus == 'success') {
                modl.find('.login-content').addClass('modal-lg');
                // title.text('Registrarme');
                resp.html(data);
                console.log(resp);
            }
        });

    }
</script>