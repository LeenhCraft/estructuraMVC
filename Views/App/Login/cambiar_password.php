<?php headerWeb('header_web', $data); ?>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1><?= $data['titulo_web']; ?></h1>
    </div>
    <div class="login-box flipped">
        <div id="divLoading">
            <div>
                <img src="<?= media(); ?>img/loading.svg" alt="Loading">
            </div>
        </div>
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="index.html">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required>
            <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required>
            <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required>
            <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
            <div class="form-group">
                <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva Contraseña" onkeyup="validarfuerza(this,'fuerza')" onblur="ocultarbarra('fuerza')" required>
                <div id="fuerza" class="progress mt-3" style="display: none;">
                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="form-group">
                <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña" onkeyup="validarfuerza(this,'fuerza2')" onblur="ocultarbarra('fuerza2')" required>
                <div id="fuerza2" class="progress mt-3" style="display: none;">
                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
            </div>
        </form>

    </div>
</section>
<?php footerWeb('footer_web', $data); ?>