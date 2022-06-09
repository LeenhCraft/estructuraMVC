<?php headerApp('Template/header_dash', $data); ?>
<div class="card">
    <div id="spinner" class="divLoading">
        <div>
            <img src="<?= media() . 'img/loading.svg'; ?>" alt="Loading">
        </div>
    </div>
    <div class="card-header px-md-5">
        <div class="row pb-md-5 border-bottom">
            <div class="col-12 text-center py-3 mb-4">
                <label class="text-primary fw-bold h3 p-0 m-0">Generar Ficha Donación</label>
            </div>
            <div class="col-md-10 mb-3 row align-items-center">
                <label class="col-2 text-start">Código Ficha:</label><label class="col-9 h5 m-0 text-primary fw-bold cod_ficha"></label>
            </div>
            <div class="col-10 row align-items-center">
                <label class="col-2 text-start" for="txtdoc">DNI/R.U.C.:</label>
                <form class="col-4" onsubmit="return bsc_pro(this)">
                    <div class="input-group">
                        <input type="text" class="form-control" id="txtdoc" placeholder="Doc. identidad" required>
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class='bx bx-search-alt-2'></i></button>
                    </div>
                </form>
            </div>
            <div class="col-2 text-end">
                <label class="me-2">Fecha:</label><label class="text-primary fw-bold"><?php echo date('d/m/Y'); ?></label>
            </div>
        </div>
    </div>
    <div class="card-body px-md-5">
        <div class="row p-md-3 border-bottom div_hidden mb-3" style="display: none;">
            <div class="col-12 text-center"><label class="h5 text-primary p-0 m-0 text-capitalize">Información del donante</label></div>
            <div class="col-12 col-md-8 my-auto">
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">DNI/R.U.C.:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold lbldoc"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Donante:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lblnombre"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Direccion:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lbldirec"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Telefono:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lblcel"></label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">E-mail:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lblemail"></label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <img class="rounded" id="imgFoto" src="http://via.placeholder.com/180x270" alt="Cargando.." width="180">
            </div>
        </div>
        <div class="row px-md-2">
            <div class="col-md-12 text-dark mb-3">
                <div class="row">
                    <label class="text-primary h5 m-0 mb-3">Insercción de Libro</label>
                    <div class="col-md-12 mb-4 border-bottom pb-3">
                        <form class="row form_bsc_libro" onsubmit="return bsc_libro(this)">
                            <div class="col-md-4">
                                <label class="form-label">Cod ISBN</label>
                                <div class="row">
                                    <div class="col-auto">
                                        <input id="cod_isbn" name="cod_isbn" type="text" class="form-control" required>
                                    </div>
                                    <button class="col-3 btn btn-outline-primary p-0 btn_cod" type="submit">buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form class="row">
                        <div class="col-md-12 row mb-2">
                            <div class="col-md-12">
                                <label class="form-label">Título</label>
                                <input id="titulo_lib" name="titulo_lib" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Editorial</label>
                            <select name="edit_lib" id="edit_lib" class="form-control">
                                <option value="1">Malaga</option>
                                <option value="2">CosmoBook</option>
                                <option value="3">Alfaguara</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Edición</label>
                            <input id="Edic_lib" name="Edic_lib" type="text" class="form-control">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Formato</label>
                            <select name="Form_lib" id="Form_lib" class="form-control">
                                <option value="1">Bolsillo</option>
                                <option value="2">Pasta Dura</option>
                                <option value="3">Pasta Blanda</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Autores</label>
                            <select name="autor_lib" id="autor_lib" class="form-control">
                                <option value="1">Malaga</option>
                                <option value="2">CosmoBook</option>
                                <option value="3">Alfaguara</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Categoria</label>
                            <input id="cat_lib" name="cat_lib" type="text" class="form-control">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Pais</label>
                            <select name="pais_lib" id="pais_lib" class="form-control">
                                <option value="1">Perú</option>
                                <option value="2">Bolivia</option>
                                <option value="3">Chile</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Cod ISBN 10 Dígitos</label>
                            <input id="isbn_10" name="isbn_10" type="text" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Cod ISBN 13 Dígitos</label>
                            <input id="isbn_13" name="isbn_13" type="text" class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Cantidad</label>
                            <input id="stock_lib" name="stock_lib" type="text" class="form-control">
                        </div>
                        <div class="col-md-9 mb-2">
                            <label class="form-label">Detalle</label>
                            <input id="det_lib" name="det_lib" type="text" class="form-control">
                        </div>
                        <div class="col-md-12 text-end pb-3 border-bottom">
                            <button id="btnInsert" type="button" class="btn btn-primary text-capitalize" onclick="agregarDetalle(this)">Insertar libro</button>
                        </div>
                    </form>

                </div>
            </div>
            <form onsubmit="return fn_submit_form(this)">
                <div class="table-responsive">
                    <input type="hidden" id="donante" name="donante">
                    <input type="hidden" id="cod_ficha" name="cod_ficha">
                    <table id="tabledetalle" class="table table-bordered table-sm">
                        <thead class="table-secondary">
                            <tr>
                                <th>Detalle de donación</th>
                                <th width="10%">Cantidad</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 text-center mt-4">
                    <button class="btn btn-outline-primary text-capitalize" type="submit"><i class='bx bx-check-circle me-2'></i>guardar ficha donación</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php footerApp('Template/footer_dash', $data); ?>