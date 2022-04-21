<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $data['titulo_web']; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <!-- <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" /> -->

    <!-- Fonts -->
    <link rel="stylesheet" href="/Assets/css/webfonts/template_web.css">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/custom.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/plugins/template_app/config.js"></script>

    <link rel="stylesheet" href="/assets/css/plugins/sweetalert2.min.css'; ?>">

</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="demo text-body fw-bolder logo">
                                    Biblio Web
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2 d-none">Welcome to Sneat!</h4>
                        <p class="mb-4 d-none">Please sign-in to your account and start the adventure</p>
                        <form id="frmlogin" class="mb-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usu" name="usuario" placeholder="Ingrese su usuario" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <a href="#">
                                        <small>¿Ha olvidado tu contraseña?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="pass" class="form-control" name="pass" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="pass" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me">Recuerdame</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Ingresar</button>
                            </div>
                            <p><a class="a-web" href="/"><i class='bx bx-chevrons-right'></i>web</a></p>
                        </form>

                        <p class="text-center d-none">
                            <span>New on our platform?</span>
                            <a href="#">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <script>
        const base_url = "<?php echo base_url(); ?>";
    </script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/js/plugins/jquery.min.js"></script>
    <script src="/assets/js/plugins/popper.min.js"></script>
    <script src="/assets/js/plugins/bootstrap.min.js"></script>
    
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="/assets/js/plugins/template_app/main.js"></script>

    <!-- Page JS -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->

    <script src="/assets/js/plugins/sweetalert2.all.min.js"></script>
    <script src="/assets/js/app/general.js"></script>
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