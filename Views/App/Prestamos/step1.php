<div id="spinner" class="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<div class="card-header px-md-5">
    <div class="row">
        <div class="col-12 col-md-3">
            <label class="form-label" for="txtCod">Código Lector</label>
            <form onsubmit="return bsc_lector(this)">
                <div class="input-group">
                    <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" onkeyup="val_press(this)">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class='bx bx-search-alt-2'></i></button>
                </div>
            </form>
        </div>
        <div class="col mt-auto text-end">
            <div class="w-auto">
                <label class="h5 fw-light">Usuario: <span class="fw-bold text-primary ms-2"><?php echo getName($_SESSION['lnh_id'])['nombre'] ?></span></label>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="div_hidden body p-md-5" style="display: none;">
    <div class="row">
        <div class="col-12 col-md-8">
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
        <div class="col-12 col-md-4 text-center">
            <img class="rounded" id="imgFoto" src="http://via.placeholder.com/180x270" alt="Cargando.." width="180">
        </div>
    </div>
</div>
<div class="body px-md-5 pb-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card accordion-item div_hidden" style="display: none;">
                <h2 class="accordion-header" id="reservas">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#reservastitle" aria-expanded="false" aria-controls="reservastitle">
                        <div class="spinner-grow spinner-grow-sm text-primary me-2 d-none" role="status">
                            <span class="sr-only"></span>
                        </div>
                        RESERVAS
                    </button>
                </h2>
                <div id="reservastitle" class="accordion-collapse collapse" aria-labelledby="reservas" data-bs-parent="#accordionExample">
                    <div class="dropdown-divider"></div>
                    <div class="accordion-body mt-3">
                        <div class="row my-3 d-none">
                            <div class="w-auto">
                                <div class=" row">
                                    <label class="col-form-label w-auto">F. Desde</label>
                                    <div class="col">
                                        <input class="form-control" type="date" value="2021-06-18">
                                    </div>
                                </div>
                            </div>
                            <div class="w-auto">
                                <div class=" row">
                                    <label class="col-form-label w-auto">F. Desde</label>
                                    <div class="col">
                                        <input class="form-control" type="date" value="2021-06-18">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table w-100 p-1 my-2" id="tbreservas">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>N° Libros</th>
                                        <th>F. Prestamo</th>
                                        <th>Estado</th>
                                        <!-- <th>   </th> -->
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr class="odd">
                                        <td valign="top" colspan="4" class="dataTables_empty text-center">Ningún dato disponible en esta tabla.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="idform" onsubmit="return fn_submit_form(this)">
            <div class="col-12 my-4 px-3">
                <div class="row">
                    <div class="col-12">
                        <span class="h4 fw-normal text-primary">Tipo de servicio: Prestamo</span>
                    </div>
                    <div class="col-12 row p-0 m-0 mt-3 pt-2">
                        <label for="fpres" class="col-md-1 col-form-label text-end" title="Fecha del prestamos">Fecha:</label>
                        <div class="col-md-2">
                            <input class="form-control" type="date" id="fpres" name="fpres" title="Fecha del prestamos">
                        </div>
                        <label for="fdev" class="col-md-1 col-form-label text-end text-truncate" title="Fecha de devolución">F. Devolución:</label>
                        <div class="col-md-2">
                            <input class="form-control" type="date" id="fdev" name="fdev" title="Fecha de devolución">
                        </div>
                    </div>
                    <div class="col-12 row p-0 m-0 my-3 py-2">
                        <input type="hidden" id="detlec" name="detlec">
                        <div class="col-md-1 my-auto text-end">
                            <label>Buscar</label>
                        </div>
                        <div class="col-lg-2">
                            <input type="number" onkeyup="return buscarLibroXCodigoISBN(this, event)" id="ingrso1" class="form-control" placeholder="Codigo ISBN" data-id="230701">
                        </div>
                        <div class="col-lg-6">
                            <select id="libros" class="form-control js-example-basic-single" placeholder="Bien / Libro / Otros">
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <input type="number" id="detll3" class="form-control text-center" value="1">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" onclick="agregarDetalle()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tabledetalle" class="table table-bordered table-sm">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Detalle prestamo</th>
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
                <!-- <button class="btn btn-outline-primary text-capitalize _disabled" onclick="gen_servicio(this)" disabled><i class='bx bx-check-circle me-2'></i>generar servicio</button> -->
                <button class="btn btn-outline-primary text-capitalize _disabled" type="submit" disabled><i class='bx bx-check-circle me-2'></i>generar servicio</button>
            </div>
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