<?php headerWeb('header_web', $data); ?>
<main>
    <div class="contenedor">
        <div class="wrap">
            <div class="box">
                <!--<span>BIENVENIDO...</span>-->
                <h1>BIENVENIDO</h1>
                <p>
                    Sistema de información administrado por la Biblioteca Municipal de
                    Nueva Cajamarca
                </p>
                <div class="botones">
                    <?php if (!isset($_SESSION['pe_u'])) {    ?>
                        <button type="button" class="btn1" data-toggle="modal" data-target="#exampleModal1">
                            INICIA SESIÓN
                        </button>
                    <?php } ?>
                    <button type="button" class="btn2" data-toggle="modal" data-target="#exampleModal2">
                        REGISTRATE
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL 1-->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">
                        Ininicar Sesión
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="font-weight-bold h4" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="usulog">
                        <div class="form-row">
                            <div class="form-group col-md-12 ft-b">
                                <label for="txtusu">Usuario</label>
                                <input type="text" class="form-control" id="txtusu" name="txtusu" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 ft-b">
                                <label for="txtpas">Contraseña</label>
                                <input type="password" class="form-control" id="txtpas" name="txtpas" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="utility">
                                <p class="h6 mb-2 text-primary"><a href="#" onclick="flip()">Olvide mi contraseña</a></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
                            <button type="submit" class="btn btn-outline-primary">Ingresar</button>
                        </div>
                    </form>
                    <form id="usureset" class="fmr_none" style="display: none;">
                        <div class="form-row">
                            <div class="form-group col-md-12 ft-b">
                                <label for="txtusu">Correo</label>
                                <input type="email" class="form-control" id="txtusu" name="txtusu" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <p class="h6 mb-2"><a href="#"  onclick="flop()"><i class="fa fa-angle-left fa-fw"></i> Iniciar sesión</a></p>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
                            <button type="submit" class="btn btn-outline-primary">Recuperar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL 2-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">
                        Registraté por primera vez
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="regusu" name="regusu" class="form-horizontal">
                        <div class="form-row">
                            <div class="form-group col-md-12 ft-b">
                                <label for="txtdni">DNI:</label>
                                <input type="number" class="form-control" id="txtdni" name="txtdni" onKeyUp="return limitar(event,this.value,8)" onKeyDown="return limitar(event,this.value,8)" required>
                            </div>
                        </div>

                        <div class="form-row div_nom" style="display: none;">
                            <div class="form-group col-md-12 ft-b">
                                <label for="txtnombre">Nombre:</label>
                                <input type="text" class="form-control" id="txtnombre" name="txtnombre" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12 ft-b">
                                <label for="txtemail">Correo:</label>
                                <input type="email" class="form-control" id="txtemail" name="txtemail" required>
                            </div>
                        </div>
                        <div class="tile-footer mt-4">
                            <button class="btn btn-primary ft-b" id="btnActionForm" type="submit" disabled>
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                <span id="btnText">Verificar</span>
                            </button>
                            <button class="btn btn-danger ft-b text-capitalize ml-2" type="button" data-dismiss="modal">
                                <i class="fa fa-lg fa-times-circle"></i>
                                <span class="text-capitalize">cerrar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php footerWeb('footer_web', $data); ?>