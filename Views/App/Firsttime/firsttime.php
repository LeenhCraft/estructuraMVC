<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $data['titulo_web']; ?></title>

    <link rel="stylesheet" href="<?php echo media() . 'css/main.css'; ?>">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/font.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/sweetalert2.min.css'; ?>">

</head>

<body>
    <div id="divLoading" style="display: none;">
        <div>
            <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
        </div>
    </div>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="lockscreen-content">
        <div class="logo">
            <h1><?php echo NOMBRE_EMPRESA; ?></h1>
        </div>
        <div class="lock-box">
            <h4 class="text-center user-name mb-3">Bienvenido </h4>
            <p class="text-center text-muted">Por motivos de seguridad te pedimos que cambies tu contraseña.</p>
            <form id="frm" class="unlock-form" action="">
                <div class="form-group">
                    <label class="control-label ft-b">Contraseña</label>
                    <input name="txtPass" id="txtPass" class="form-control" type="password" placeholder="Password" autofocus onkeyup="validarfuerza(this,'fuerza')" onblur="ocultarbarra('fuerza')" required>
                    <div id="fuerza" class="progress mt-3" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label ft-b">Confirmar Contraseña</label>
                    <input name="txtConPass" id="txtConPass" class="form-control" type="password" placeholder="Password" onkeyup="validarfuerza(this,'fuerza2')" onblur="ocultarbarra('fuerza2')" required>
                    <div id="fuerza2" class="progress mt-3" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block ft-b" type="submit">
                        <i class="fa fa-unlock fa-lg"></i> Guardar
                    </button>
                </div>
            </form>
            <p><a class="ft-b" href="/logout">Salir del sistema</a></p>
        </div>
    </section>
    <script>
        const base_url = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo media() . 'js/plugins/jquery.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/popper.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/main.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/sweetalert2.all.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/pace.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/dataTables.bootstrap.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/app/general.js'; ?>"></script>
    <script src="<?php echo media() . 'js/app/fn_firsttime.js'; ?>"></script>

</body>

</html>