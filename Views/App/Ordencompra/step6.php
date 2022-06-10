<div id="spinner" class="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<div class="card-header px-md-5">
    <div class="row">
        <br>
        <h5>ORDEN DE COMPRA</h5></br>
        <br></br>

        <div class="col-12 col-md-8">
            <div class="row">
                <div class="col">
                    <label id="cod" name="cod" class="h5 fw-light ">Proveedor:</label>
                    <div class="col-md-5">
                        <form onsubmit="return bsc_lector(this)">
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
                    <label id="cod" name="cod" class="h5 fw-light">Codigo Orden: <span class="fw-bold text-primary ms-2"><?php echo generar_numeros(5); ?></span></label>

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
    <div class="div_hidden body p-md-5" style="display: none;">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="row mb-md-2 d-none">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Código:</label>
                    <div class="col-sm-10">
                        <label class="form-control border-0 border-bottom"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Lector:</label>
                    <div class="col-sm-10">
                        <label class="form-control border-0 border-bottom" id="lblnombre"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">DNI:</label>
                    <div class="col-sm-10">
                        <label class="form-control border-0 border-bottom" id="lbldni"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Dirección:</label>
                    <div class="col-sm-10">
                        <label class="form-control border-0 border-bottom" id="lbldirec"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Celular:</label>
                    <div class="col-sm-10">
                        <label class="form-control border-0 border-bottom" id="lblcel"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">E-mail:</label>
                    <div class="col-sm-10">
                        <label class="form-control border-0 border-bottom" id="lblusu"></label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 text-center">
                <img class="rounded" id="imgFoto" src="http://via.placeholder.com/180x270" alt="Cargando.." width="180">
            </div>
        </div>
    </div>






    <div class="body px-md-6 pb-md-6">
        <div class="row">

            <form id="idform">
                <div class="col-12 my-4 px-3">
                    <div class="row">
                        
                    <div class="table-responsive text-nowrap">
                            <table id="tbincidencias" class="table w-100 p-1">
                                <thead>
                                    <tr>
                                        <th>Id_Incidencia</th>
                                        <th>Cod. Prestamo</th>
                                        <th>Motivo</th>
                                        <th>Libro</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr class="odd">
                                        <td valign="top" colspan="4" class="dataTables_empty">Ningún dato disponible en esta tabla.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>



                        <div class="col-12 my-1">

                        </div>



                    </div>
                </div>
                <div class="col-12 text-center mt-4">
                    <button class="btn btn-outline-primary text-capitalize " type="submit"><i class='bx bx-check-circle me-2'></i>Generar Orden</button>
                </div>
                <!--<div class="col-12 text-center mt-4">
                    <button class="btn btn-outline-primary text-capitalize _disabled" type="submit" disabled><i class='bx bx-check-circle me-2'></i>generar requerimiento</button>
                </div>-->

            </form>
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