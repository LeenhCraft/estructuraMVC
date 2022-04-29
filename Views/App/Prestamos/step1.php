<div id="spinner" class="divLoading">
    <div>
        <img src="http://project.test/Assets/img/loading.svg" alt="Loading">
    </div>
</div>
<div class="card-header">
    <div class="row">
        <div class="col-12 col-md-3">
            <label class="form-label" for="txtCod">Código Lector</label>
            <div class="input-group">
                <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" onkeyup="val_press(this)">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="bsc_lector(this);"><i class='bx bx-search-alt-2'></i></button>
            </div>
        </div>
        <div class="col-12 col-md-3 mt-auto">
            <?php
            if ($data['permisos']['perm_w'] == 1) {
            ?>
                <button type="button" class="btn rounded-pill btn-outline-primary">
                    <span class="tf-icons bx bx-plus-circle me-2"></span>Agregar Lector
                </button>
            <?php
            }
            ?>
        </div>
        <div class="col mt-auto text-end">
            <label class="form-control">Usuario: <span><?php echo getName($_SESSION['lnh_id'])['nombre'] ?></span></label>
        </div>
    </div>
</div>
<hr>
<div class="body p-md-5">
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
        <div class="col-12 col-md-4 offset-8 text-center mt-4">
            <button class="btn btn-outline-danger"><i class='bx bx-alarm-exclamation me-2'></i>Generar Incidencia</button>
        </div>
    </div>
</div>
<hr>
<div class="body px-md-5 pb-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card accordion-item">
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
                        <div class="row my-3">
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
                            <table class="table w-100 p-1" id="tbreservas">
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
                                        <td valign="top" colspan="4" class="dataTables_empty">Ningún dato disponible en esta tabla.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-4">
            <div class="card accordion-item">
                <h2 class="accordion-header" id="incidencias">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#incidenciastitle" aria-expanded="false" aria-controls="incidenciastitle">
                        <div class="spinner-grow spinner-grow-sm text-primary me-2 d-none" role="status">
                            <span class="sr-only"></span>
                        </div>
                        INCIDENCIAS
                    </button>
                </h2>
                <div id="incidenciastitle" class="accordion-collapse collapse" aria-labelledby="incidencias" data-bs-parent="#accordionExample">
                    <div class="dropdown-divider"></div>
                    <div class="accordion-body">
                        <div class="row my-3">
                            <div class="w-auto">
                                <div class=" row">
                                    <label for="" class="col-form-label w-auto">F. Desde</label>
                                    <div class="col">
                                        <input class="form-control" type="date" value="2021-06-18">
                                    </div>
                                </div>
                            </div>
                            <div class="w-auto">
                                <div class=" row">
                                    <label for="" class="col-form-label w-auto">F. Desde</label>
                                    <div class="col">
                                        <input class="form-control" type="date" value="2021-06-18">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table id="tbincidencias" class="table w-100 p-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cod. Reserva</th>
                                        <th>Libro</th>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr class="odd">
                                        <td valign="top" colspan="4" class="dataTables_empty">Ningún dato disponible en esta tabla.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center mt-4">
            <button class="btn btn-outline-primary text-capitalize _disabled" onclick="gen_servicio(this)" disabled><i class='bx bx-check-circle me-2'></i>generar servicio</button>
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