<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?php echo $data['titulo_web']; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <link rel="icon" type="image/png" href="<?php echo media(); ?>img/logo.png">

    <meta name="Author" lang="es" content="leenhcraft.com">

    <!-- Facebook Opengraph integration: https://developers.facebook.com/docs/sharing/opengraph -->
    <meta property="og:title" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:description" content="">

    <!-- Twitter Cards integration: https://dev.twitter.com/cards/  -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/bootstrap.css'; ?>">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/font.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo media() . 'css/plugins/sweetalert2.min.css'; ?>">

    <?php
    if (isset($data['css']) && !empty($data['css'])) {
        for ($i = 0; $i < count($data['css']); $i++) {
            echo '<link rel="stylesheet" type="text/css" href="' . media() . $data['css'][$i] . '">';
        }
    }
    ?>

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
                <div class="form-group d-none">
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

    <script>
        const base_url = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo media() . 'js/plugins/jquery.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/popper.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/plugins/sweetalert2.all.min.js'; ?>"></script>
    <script src="<?php echo media() . 'js/app/general.js'; ?>"></script>
    <script>
        function verpass(e, input) {
            let selector = "#" + input;
            let elem = $(selector);
            console.log(elem);

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

            if (elem.match(/([0-9]+).*\1{2}/)) {
                fuerza += -25;
            }
            console.log(fuerza);
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
    </script>
    <?php
    if (isset($data['js']) && !empty($data['js'])) {
        for ($i = 0; $i < count($data['js']); $i++) {
            echo '<script src="' . media() . $data['js'][$i] . '"></script>';
        }
    }
    ?>
</body>

</html>