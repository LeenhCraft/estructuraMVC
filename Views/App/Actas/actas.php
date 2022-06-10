<?php headerApp('Template/header_dash', $data); ?>
<div class="card">
    <div class="card-header p-0 px-md-5 text-dark">
        <div class="row pb-md-5 border-bottom">
            <!-- titulo -->
            <div class="col-12 text-center py-3 mb-4">
                <label class="text-primary fw-bold h3 p-0 m-0">Generar Acta</label>
            </div>
            <!-- end titulo -->
            <div class="col-12 col-md-3">
                <label class="form-label" for="txtCod">Donante</label>
                <form id="inpDon" onsubmit="return bsc_donacion(this)">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" required>
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class='bx bx-search-alt-2'></i></button>
                    </div>
                </form>
            </div>
            <div class="col-md">
                <div class="row">
                    <div class="col-md-12 mb-3 text-end">
                        <label class="text-start">Código Acta:</label>
                        <label class="h5 m-0 text-primary fw-bold cod_ficha">12345</label>
                    </div>
                    <div class="col-md-12 text-end">
                        <label class="me-2">Fecha:</label><label class="text-primary fw-bold"><?php echo date('d/m/Y'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body px-md-5">
    <form onsubmit="return fn_submit_form(this)">
            <div id="spinner" class="divLoading">
                <div>
                    <img src="<?= media() . 'img/loading.svg'; ?>" alt="Loading">
                </div>
            </div>
            <input type="hidden" id="idDona" name="idDona">
            <input type="hidden" id="codActa" name="codActa">
            <div class="row p-md-3 div_hidden mb-3" style="display: none;">
                <div class="col-md-6 p-0 px-2">
                    <div class="row mb-md-2">
                        <label class="col-md-2 text-end fw-bold p-0" for="basic-default-name">Nombre: </label>
                        <label class="col-md-10 text-primary fw-bold lblname"></label>
                    </div>
                    <div class="row mb-md-2">
                        <label class="col-md-2 text-end fw-bold p-0" for="basic-default-name">Doc.: </label>
                        <label class="col-md-10 text-primary fw-bold lbldoc"></label>
                    </div>
                    <div class="row mb-md-2">
                        <label class="col-md-2 text-end fw-bold p-0" for="basic-default-name">Dirección.: </label>
                        <label class="col-md-10 text-primary fw-bold lbldir"></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-md-2">
                        <label class="col-md-2 text-end fw-bold p-0" for="basic-default-name">T. Persona: </label>
                        <label class="col-md-10 text-primary fw-bold lbltper"></label>
                    </div>
                    <div class="row mb-md-2">
                        <label class="col-md-2 text-end fw-bold p-0" for="basic-default-name">Celular: </label>
                        <label class="col-md-10 text-primary fw-bold lblcel"></label>
                    </div>
                    <div class="row mb-md-2">
                        <label class="col-md-2 text-end fw-bold p-0" for="basic-default-name">E-mail: </label>
                        <label class="col-md-10 text-primary fw-bold lblemail"></label>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap mb-4">
                <table id="lstDonaciones" class="table table-hover" width="100%">
                    <thead class="border-top">
                        <tr>
                            <th>N°</th>
                            <th>Codigo</th>
                            <th>T. Persona</th>
                            <th>Tipo</th>
                            <th>Persona</th>
                            <th>T. Libros</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center text-capitalize">sin datos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="div_detDona" style="display: none;">
                <div class="col-md-12 text-center text-primary py-md-2"><label class="fw-bold">Detalle de la Ficha donación</label></div>
                <div class="table-responsive text-nowrap mb-4">
                    <table id="detDonacion" class="table table-hover" width="100%">
                        <thead class="border-top">
                            <tr>
                                <th>N° Donación</th>
                                <th>Cod. Libro</th>
                                <th>ISBN</th>
                                <th>Titulo</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center text-capitalize">sin datos</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button class="btn btn-primary text-capitalize" type="submit">Generar Acta</button>
            </div>
        </form>
    </div>
</div>
<?php footerApp('Template/footer_dash', $data); ?>