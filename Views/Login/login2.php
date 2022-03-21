<?php headerWeb('header_web',$data); ?>
<div id="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<div class="container d-flex align-items-center" style="height: 100vh;">
    <div class="w-100 d-flex justify-content-center">

        <div class="col-12 col-sm-11 col-md-6">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Login</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fa-solid fa-gears"></i></a>
                </li>

            </ul>
            <div class="tab-content h-100 border-right border-left border-bottom" id="myTabContent">
                <div class="tab-pane fade show active h-100" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="p-4 h-100">
                        <form id="frmlogin">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input type="email" class="form-control" id="usuario" name="usuario" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie más.</small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="pass">
                            </div>
                            <button type="submit" class="btn btn-primary float-left">
                                <i class="fa fa-sign-in fa-lg fa-fw" aria-hidden="true"></i>
                                Iniciar Sesión
                            </button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane h-100 fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="tab-pane fade show active h-100" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="p-4 h-100">
                            <form id="frmregister">
                                <div class="form-group">
                                    <label for="regusu">E-mail</label>
                                    <input type="email" class="form-control" id="regusu" name="regusu">
                                </div>
                                <div class="form-group">
                                    <label for="regpass" class="help">Contraseña <span data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="regpass" name="regpass" onkeyup="validarfuerza(this,'fuerza')" onblur="ocultarbarra('fuerza')">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="verpass(this,'regpass')"><i class="fa-solid fa-eye"></i></button>
                                        </div>
                                    </div>
                                    <div id="fuerza" class="progress mt-3" style="display: none;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="regpass">Confirmar contraseña <span data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="regconpass" name="regconpass" onkeyup="validarfuerza(this,'fuerza2')" onblur="ocultarbarra('fuerza2')">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="verpass(this,'regconpass')"><i class="fa-solid fa-eye"></i></button>
                                        </div>
                                    </div>
                                    <div id="fuerza2" class="progress mt-3" style="display: none;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary float-left">
                                    <i class="fa fa-sign-in fa-lg fa-fw" aria-hidden="true"></i>
                                    Registrarme
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerWeb('footer_web',$data); ?>