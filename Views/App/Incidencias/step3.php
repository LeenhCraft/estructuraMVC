<div id="spinner" class="divLoading">
    <div>
        <img src="http://project.test/Assets/img/loading.svg" alt="Loading">
    </div>
</div>
<div class="card-header">

    <div class="row">
        <br>
        <h5>FICHA INCIDENCIA</h5></br>

        <div class="col-12 col-md-8">
            <div class="col-12 col-md-3">
                <label class="form-label" for="txtCod">Código Lector</label>

                <div class="input-group">
                    <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" onkeyup="val_press(this)">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="bsc_lector(this);"><i class='bx bx-search-alt-2'></i></button>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 text-center">

            <div class="col-6 mt-auto text-end">
                <div class=" row">
                    <label class="col-form-label w-auto">Fecha</label>
                    <div class="col">
                        <label><?= date('d/m/Y'); ?></label>
                        <!--<input class="form-control" type="date" value="">-->
                    </div>
                </div>
            </div>
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

        </div>
        <div class="col-12 col-md-4 text-center">
            <img class="rounded" id="imgFoto" src="http://via.placeholder.com/180x200" alt="Cargando.." width="180">
        </div>
        <!-- <div class="col-12 col-md-4 offset-8 text-center mt-4">
            <button class="btn btn-outline-danger"><i class='bx bx-alarm-exclamation me-2'></i>Generar Incidencia</button>
        </div>-->
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
                        PRESTAMOS REALIZADOS
                    </button>
                </h2>
                <div id="reservastitle" class="accordion-collapse collapse" aria-labelledby="reservas" data-bs-parent="#accordionExample">
                    <div class="dropdown-divider"></div>
                    <div class="accordion-body mt-3">

                        <div class="table-responsive text-nowrap">
                            <table class="table w-100" id="tbreservas">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>N° Prestamo</th>
                                        <th>F. Prestamo</th>
                                        <th>F. Devolucion</th>
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
                            <?php
                            getModal('mdlLibros');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 my-4">
            <div class="card accordion-item">
                <h2 class="accordion-header" id="ficha">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#fichatitle" aria-expanded="false" aria-controls="fichatitle">
                        <div class="spinner-grow spinner-grow-sm text-primary me-2 d-none" role="status">
                            <span class="sr-only"></span>
                        </div>
                        GENERAR INCIDENCIA
                    </button>
                </h2>
                <div id="fichatitle" class="accordion-collapse collapse" aria-labelledby="ficha" data-bs-parent="#accordionExample">
                    <div class="dropdown-divider"></div>
                    <div class="accordion-body mt-3">
                        <!--<div class="row my-3">
                            <div class="w-auto">
                                <div class=" row">
                                    <label class="col-form-label w-auto">F. Desde</label>
                                    <div class="col">
                                        <label class="form-control border-0 border-bottom" id="lblnombre"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-auto">
                                <div class=" row">
                                    <label class="col-form-label w-auto">F. Desde</label>
                                    <div class="col">
                                        <input class="form-control" type="date" value="2022-06-18">
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <form id="frm_inci" onsubmit="return inci(this)">
                            <div class="row">
                                <input type="hidden" id="item_book" name="item_book" value="">
                                <input type="hidden" id="pres_cod" name="pres_cod" value="">
                                <div class="col-12 col-md-5">
                                    <div class="row mb-md-2 p-0">
                                        <label class="col-sm-3  fw-bold text-start" for="basic-default-name">ISBN:</label>
                                        <div class="col-sm-8">

                                            <!-- <label for="txtIdmotivos" onclick="lstmotivos()" class="mb-2">Incidencia</label>-->

                                            <label class="text-primary text-start" id="lblisbn"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="row mb-md-2 p-0">
                                        <label class="col-sm-3  fw-bold text-start" for="basic-default-name">Libro:</label>
                                        <div class="col-sm-9">
                                            <label class="text-primary text-start" id="lblbook"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="txtIdmotivos" onclick="lstmotivos()" class="mb-2">Incidencia</label>
                                    <select name="txtIdmotivos" id="txtIdmotivos" class="form-control text-capitalize">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="row p-3">
                                        <label class="p-0 mb-2">Detalle incidencia</label>
                                        <div class="col-12 border p-4">
                                            <div class="row px-1">
                                                <div class="col-md-4">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox" value="Rayado" id="defaultCheck1" name="det_1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Rayado
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox" value="Hojas faltantes" id="defaultCheck2" name="det_2">
                                                        <label class="form-check-label" for="defaultCheck2">
                                                            Hojas faltantes
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox" value="Cortado o roto" id="defaultCheck3" name="det_3">
                                                        <label class="form-check-label" for="defaultCheck3">
                                                            Cortado o roto
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-outline-primary float-end btn_inci" type="submit">Insertar incidencia</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center mt-4 d-none">
            <button class="btn btn-outline-primary text-capitalize _disabled" onclick="" disabled><i class='bx bx-check-circle me-2'></i>generar ficha</button>
        </div>


        <div class="col-12 my-1">
            <div class="card accordion-item">
                <h2 class="accordion-header" id="incidencias">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#incidenciastitle" aria-expanded="false" aria-controls="incidenciastitle">
                        <div class="spinner-grow spinner-grow-sm text-primary me-2 d-none" role="status">
                            <span class="sr-only"></span>
                        </div>
                        DETALLE INCIDENCIA
                    </button>
                </h2>
                <div id="incidenciastitle" class="accordion-collapse collapse" aria-labelledby="incidencias" data-bs-parent="#accordionExample">
                    <div class="dropdown-divider"></div>
                    <div class="accordion-body">

                        <div class="table-responsive text-nowrap">
                            <table id="tbincidencias" class="table w-100 p-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
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
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>