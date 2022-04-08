<footer>
    <div class="contenedor-footer">
        <div class="content-foo">
            <h4>Contáctanos</h4>
            <p><a class="text-white font-weight-light text-capitalize" target="_blank" href="/login">intranet</a></p>
        </div>
        <div class="content-foo">
            <h4>Resolvemos tus consultas en</h4>
            <p>smilingdvg@gmail.com</p>
        </div>
        <div class="content-foo">
            <h4>Nos encontramos en</h4>
            <p>Rioja - Nueva Cajamarca</p>
        </div>
    </div>
    <h2 class="titulo-final">
        &copy;2022 Copyright Biblioteca municipal Nueva Cajamarca | Todos los
        derechos reservados
    </h2>
</footer>
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