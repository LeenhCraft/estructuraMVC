<div id="spinner" class="divLoading">
    <div>
        <img src="http://project.test/Assets/img/loading.svg" alt="Loading">
    </div>
</div>
<div class="card-header">
    <div class="row">
    <br><h5>Generar Devolución</h5></br>
        <div class="col-12 col-md-3">
            <label class="form-label" for="txtCod">Código Lector</label>

            
            <div class="input-group">
                <input type="text" class="form-control" id="txtCod" placeholder="0123" aria-describedby="button-addon2" onkeyup="val_press(this)">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="bsc_lector(this);"><i class='bx bx-search-alt-2'></i></button>
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
            <img class="rounded" id="imgFoto" src="https://via.placeholder.com/180x200" alt="Cargando.." width="180">
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
                        REALIZAR DEVOLUCION
                    </button>
                </h2>
                <div id="reservastitle" class="accordion-collapse collapse" aria-labelledby="reservas" data-bs-parent="#accordionExample">
                    <div class="dropdown-divider"></div>
                    <div class="accordion-body mt-3">
                        
                        <div class="table-responsive text-nowrap">
                            <table class="table w-100 p-1" id="tbreservas" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>cod</th>
                                        <th>N° Libros</th>
                                        <th>F. Prestamo</th>
                                        <th>F. Devolucion</th>
                                        <th>Estado</th>
                                        <th width="10%"></th>
                                        
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

        <div class="table-responsive text-nowrap mt-5">
        <span class="text-capitalize fw-bold text-primary">detalle devolucion</span>
        <table class="table w-100 p-1 table table-hover" id="tbdetalledev">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cod. Prestamo</th>
                    <th>Cod. ISBN</th>
                    <th>Titulo</th>
                    <th>Editorial</th>
                    <th>Autor</th>
                    <th>Edicion</th>
                    <th>Formato</th>
                
                    
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <tr class="odd">
                    <td valign="top" colspan="7" class="dataTables_empty text-center">Ningún dato disponible en esta tabla.</td>
                </tr>
            </tbody>
        </table>
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

