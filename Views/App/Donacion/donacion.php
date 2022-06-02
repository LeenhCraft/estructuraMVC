<?php headerApp('Template/header_dash', $data); ?>
<div class="card">
    <div id="spinner" class="divLoading">
        <div>
            <img src="<?= media().'img/loading.svg';?>" alt="Loading">
        </div>
    </div>
    <div class="card-header px-md-5">
        <div class="row pb-md-5 border-bottom">
            <div class="col-12 text-center py-3 mb-4">
                <label class="text-primary fw-bold h3 p-0 m-0">Generar Donación</label>
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
        <div class="row p-md-3 border-bottom div_hidden" style="display: none;">
            <div class="col-12 text-center"><label class="h5 text-primary p-0 m-0 text-capitalize">Información del donante</label></div>
            <div class="col-12 col-md-8 my-auto">
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">DNI/R.U.C.:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold lbldoc">lnh</label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Donante:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lblnombre">lnh</label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Direccion:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lbldirec">lnh</label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">Telefono:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lblcel">lnh</label>
                    </div>
                </div>
                <div class="row mb-md-2">
                    <label class="col-sm-2 col-form-label text-end fw-bold" for="basic-default-name">E-mail:</label>
                    <div class="col-sm-10 d-flex align-items-center">
                        <label class="text-primary fw-bold" id="lblemail">lnh</label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <img class="rounded" id="imgFoto" src="http://via.placeholder.com/180x270" alt="Cargando.." width="180">
            </div>
        </div>
        <div class="row p-md-3">
            <div class="nav-align-top">
                <ul class="nav nav-tabs nav-fill " role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#select-libro" aria-controls="select-libro" aria-selected="true" onclick="select_libros(this)">
                            <i class='tf-icons bx bx-book-bookmark me-2'></i>
                            Seleccionar Libro
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#new-libro" aria-controls="new-libro" aria-selected="false" onclick="new_libro(this)">
                            <i class='tf-icons bx bxs-book-add me-2'></i>
                            Registrar un nuevo libro
                        </button>
                    </li>
                </ul>
                <div class="tab-content shadow-none">
                    <div class="tab-pane fade active show" id="select-libro" role="tabpanel"></div>
                    <div class="tab-pane fade" id="new-libro" role="tabpanel"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerApp('Template/footer_dash', $data); ?>