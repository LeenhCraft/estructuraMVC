<div id="spinner" class="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<div class="card-header px-md-5">
    <div class="row">
        <br>
        <h5>PROFORMA</h5></br>
        <br></br>

        <div class="col-12 col-md-8">
            <div class="row">
                <div class="col">
                    <label id="cod" name="cod" class="h5 fw-light ">Proveedor:</label>
                    <div class="col-md-5">
                        <form onsubmit="return bsc_proveedor(this)">
                            <div class="input-group">
                                <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" onkeyup="val_press(this)">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class='bx bx-search-alt-2'></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12 col-md-4">
            <div class="row">
                <div class="col">
                    <!<label id="cod" name="cod" class="h5 fw-light">Codigo proforma: <span class="fw-bold text-primary ms-2"><?php echo generar_numeros(5); ?></span></label>

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
    <!--<div class="div_hidden body p-md-2" style="display: none;">-->

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="row mb-md-2 d-none">
                <label class="col-sm-3  text-end fw-bold" for="basic-default-name">Código:</label>
                <div class="col-sm-9">
                    <label class="form-control border-0 border-bottom"></label>
                </div>
            </div>
            <div class="row mb-md-2">
                <label class="col-sm-3  text-end fw-bold" for="basic-default-name">Proveedor:</label>
                <div class="col-sm-9">
                    <label class="form-control border-0 border-bottom" id="lblnombre"></label>
                </div>
            </div>
            <div class="row mb-md-2">
                <label class="col-sm-2  text-end fw-bold" for="basic-default-name">Doc:</label>
                <div class="col-sm-8">
                    <label class="form-control border-0 border-bottom" id="lbldni"></label>
                </div>
            </div>

        </div>
        <div class="col-12 col-md-6">
            <div class="row mb-md-2">
                <label class="col-sm-3 text-end fw-bold" for="basic-default-name">Celular:</label>
                <div class="col-sm-8">
                    <label class="form-control border-0 border-bottom" id="lblcel"></label>
                </div>
            </div>
            <div class="row mb-md-2">
                <label class="col-sm-3 text-end fw-bold" for="basic-default-name">E-mail:</label>
                <div class="col-sm-8">
                    <label class="form-control border-0 border-bottom" id="lblusu"></label>
                </div>
            </div>
        </div>

        <!--</div>-->

        <br></br>
        <br></br>
        <div class="body px-md-6 pb-md-6">
            <div class="row p-3">
            
                    <!-- aqui coloco el campo oculto con el valor del codigo -->
                    <input type="hidden" name="prof_cod" id="prof_cod">
                    <span class="h5 text-capitalize fw-bold text-primary">INSERCIÓN PROFORMA</span>

                    <div class="col-12 border p-4">
                        <div class="col">
                            <label id="cod" name="cod" class="h5 fw-light ">Buscar Requerimiento:</label>
                            <div class="col-md-3">
                                <form onsubmit="return bsc_requerimiento(this)">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="codReq" placeholder="Código de requerimiento" aria-describedby="button-addon3">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon3"><i class='bx bx-search-alt-2'></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br></br>
                        <div class="table-responsive text-nowrap mb-4">
                            <table id="tbrequerimiento" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID REQ</th>
                                        <th>COD REQUERIMIENTO</th>
                                        <th>Título</th>
                                        <th>Cantidad</th>
                                        <th>Precio / Agregar</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- -->
                    <br></br>

                    <span class="h5 text-capitalize fw-bold text-primary">Detalle de la Porforma</span>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tabledetalle" class="table table-bordered table-sm">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Título</th>
                                        <th width="10%">Cantidad</th>
                                        <th width="10%">Precio</th>
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