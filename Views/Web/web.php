<?php headerWeb('header_web', $data); ?>
<div class="container d-none">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus tenetur ab, ullam totam commodi recusandae laboriosam incidunt autem. Ducimus praesentium culpa neque. Fuga ipsam beatae officia aliquid ipsa eius incidunt.</p>
    <a href="login" class="form-control">Log in</a>
    <?php
    dep($_SESSION);
    ?>
</div>
<main>
    <div class="contenedor">
        <div class="wrap">
            <div class="box">
                <!--<span>BIENVENIDO...</span>-->
                <h1>BIENVENIDO</h1>
                <p>Sistema de información administrado por la Biblioteca Municipal de Nueva Cajamarca</p>
                <div class="botones">
                    <a href="/login" class="btn1">INICIA SESIÓN</a>
                    <a href="#" class="btn2">REGISTRATE</a>
                </div>
            </div>
        </div>
    </div>
</main>


<footer>
    <div class="contenedor-footer">
        <div class="content-foo">
            <h4>Contáctanos</h4>

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
    <h2 class="titulo-final">&copy;2022 Copyright Biblioteca municipal Nueva Cajamarca | Todos los derechos reservados</h2>
</footer>
<?php footerWeb('footer_web', $data); ?>