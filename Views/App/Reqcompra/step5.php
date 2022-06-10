<div id="spinner" class="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<div class="card-header px-md-5">
    <div class="row">
        <br>
        <h5>FICHA REQUERIMIENTO COMPRA POR LIBRO</h5></br>
        <br></br>
        <!-- <div class="col-12 col-md-3">
            <label class="form-label" for="txtCod">Código Lector</label>
            <form onsubmit="return bsc_lector(this)">
                <div class="input-group">
                    <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" onkeyup="val_press(this)">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class='bx bx-search-alt-2'></i></button>
                </div>
            </form>
        </div>-->
        <div class="col-12 col-md-8">
            <div class="w-auto">
                <label class="h5 fw-light">Usuario: <span class="fw-bold text-primary ms-2"><?php echo getName($_SESSION['lnh_id'])['nombre'] ?></span></label>
                <p class="h5 fw-light">Rol: <span class="fw-bold text-primary ms-2"><?php echo getName($_SESSION['lnh_id'])['rol'] ?></span></p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="row">
                <div class="col">
                    <label id="codf" name="codf" class="h5 fw-light">Codigo ficha: <span class="fw-bold text-primary ms-2 cod_ficha"></span></label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="h5 fw-light">Fecha: </label>
                    <label class="h5 fw-light"><?= date('d/m/Y'); ?></label>
                </div>
            </div>

        </div>

    </div>
    <hr>

    <div class="body px-md-6 pb-md-6">
        <div class="row">
            <!-- ojo, porque puse el campo en esta seccion y no arriba donde esta la ficha, porque dentro de este form esta el boton, y cuando le das click lo que te enviara al backen es todo lo que esta dentro de este form-->
            <form id="idform" onsubmit="return gen_req(this)">
                <!-- aqui coloco el campo oculto con el valor del codigo -->
                <input type="hidden" name="ficha_cod" id="ficha_cod">
                <div class="col-12 my-4 px-3">
                    <div class="row">
                        <div class="col-12">
                            <!-- <span class="h5 fw-normal text-primary">INSERCIÓN DE LIBROS</span>-->
                            <span class="h5 text-capitalize fw-bold text-primary">INSERCIÓN DE LIBROS</span>
                        </div>

                        <!--<div class="col-12 row p-0 m-0 my-3 py-2">
                            <input type="hidden" id="detlec" name="detlec">

                            <div class="col-lg-7">
                                <label class="col-sm-3  fw-bold text-start " for="basic-default-name">Nombre del libro</label>
                                <select id="libros" class="form-control js-example-basic-single" placeholder="Bien / Libro / Otros">
                                </select>
                            </div>

                            <div class="col-lg-1">
                                <label class="row-sm-3  fw-bold text-start " for="basic-default-name">Cantidad</label>
                                <input type="number" id="detll3" class="form-control text-center" value="1">
                            </div>

                            <div class="col-lg-2">
                                <label class="col-sm-3  fw-bold text-start " for="basic-default-name">f</label>
                                <button type="button" onclick="agregarDetalle()" class="btn btn-primary"><i class="fas fa-plus"></i> Añadir libro</button>
                            </div>

                            <br></br>


                        </div>
                    -->
                        <br></br>

                        <div class="table-responsive text-nowrap mb-4">
                            <table id="tblibro" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ISBN</th>
                                        <th>Título</th>
                                        <th>Autor</th>
                                        <th>Stock</th>
                                        <th>Libro/cantidad</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                        <br></br>
                        <br></br>
                        <span class="h5 text-capitalize fw-bold text-primary">Detalle Requerimiento</span>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tabledetalle" class="table table-bordered table-sm">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>Título</th>
                                            <th width="10%">Cantidad</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mt-4">
                    <button class="btn btn-outline-primary text-capitalize " type="submit"><i class='bx bx-check-circle me-2'></i>generar requerimiento</button>
                </div>
                <!--<div class="col-12 text-center mt-4">
                    <button class="btn btn-outline-primary text-capitalize _disabled" type="submit" disabled><i class='bx bx-check-circle me-2'></i>generar requerimiento</button>
                </div>-->

            </form>
        </div>
    </div>


    <script>
        function val_press(e) {
            let input = $(e);
            if (input.val().length != "") {
                $("._disabled").attr("disabled", false);
            } else {
                $("._disabled").attr("disabled", true);
            }
        }
    </script>