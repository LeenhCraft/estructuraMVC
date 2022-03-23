<?php headerWeb('header_web', $data); ?>
<div id="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>Biblio Web</h1>
    </div>
    <div class="login-box">
        <form id="frmlogin" class="login-form">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Iniciar sesion</h3>
            <div class="form-group">
                <label class="control-label ft-b">Usuario</label>
                <input id="usu" name="usuario" class="form-control" type="email" placeholder="email" autofocus>
            </div>
            <div class="form-group">
                <label class="control-label ft-b">Contraseña</label>
                <input id="pass" name="pass" class="form-control" type="password" placeholder="Password">
            </div>
            <div class="form-group">
                <div class="utility">
                    <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Olvide mi contraseña</a></p>
                </div>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Iniciar sesión</button>
            </div>
        </form>
        <form id="frmreset" class="forget-form">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Olvide mi contraseña</h3>
            <div class="form-group">
                <label class="control-label">Email</label>
                <input id="txtEmailReset" name="txtEmailReset" class="form-control" type="text" placeholder="Email">
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Reestrablecer</button>
            </div>
            <div class="form-group mt-3">
                <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar sesión</a></p>
            </div>
        </form>
    </div>
</section>
<?php footerWeb('footer_web', $data); ?>