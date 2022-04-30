<div id="spinner" class="divLoading">
    <div>
        <img src="<?php echo media() . 'img/loading.svg' ?>" alt="Loading">
    </div>
</div>
<div class="card-header">
    <div class="row">
        <div class="col">
            <div class="row px-2">
                <label class="w-auto h4 p-0 me-2 fw-light">Cod. Prestamo:</label>
                <label class="w-auto h4 p-0 me-5 fw-bold">ASD003</label>
                <label class="w-auto h4 p-0 me-2 fw-light">Lector:</label>
                <label class="w-auto h4 p-0 fw-bold">nombre lector</label>
            </div>
        </div>
        <div class="col-2 text-end">
            <button class="text-capitalize btn btn-outline-secondary" onclick="step(this)"><i class='bx bx-arrow-back me-2'></i>atrás</button>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="row mb-3">
                <label for="exampleFormControlSelect1" class="w-auto my-auto me-2 text-capitalize">tipo solicitud:</label>
                <div class="col">
                    <select class="form-select w-auto" id="exampleFormControlSelect1" aria-label="Default select example">
                        <option value="0">Prestamo</option>
                        <option value="1">Reserva</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="card-body">
    <div class="table-responsive text-nowrap mb-5">
        <span class="text-capitalize fw-bold text-primary">buscar libro</span>
        <table class="table w-100 p-1 table table-hover" id="tblibros">
            <thead>
                <tr>
                    <th>Cod. ISBN</th>
                    <th>Titulo</th>
                    <th>Stock</th>
                    <!-- <th>Estado</th>
                    <th>Operaciones</th> -->
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <tr class="odd">
                    <td valign="top" colspan="5" class="dataTables_empty text-center">Ningún dato disponible en esta tabla.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive text-nowrap mt-5">
        <span class="text-capitalize fw-bold text-primary">detalle prestamo</span>
        <table class="table w-100 p-1 table table-hover" id="tbdetalle">
            <thead>
                <tr>
                    <th>Cod. ISBN</th>
                    <th>Titulo</th>
                    <th>Editorial</th>
                    <th>Autor</th>
                    <th>Edicion</th>
                    <th>Formato</th>
                    <th>Operaciones</th>
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
<div class="card-footer text-center">
    <hr>
    <button type="button" class="btn btn-primary text-capitalize"><i class='bx bx-save'></i>generar</button>
</div>
<script>
    $(document).ready(function() {
        $("#tblibros").dataTable({
            aProcessing: true,
            aServerSide: true,
            language: {
                url: base_url + "Assets/js/plugins/dataTable.Spanish.json",
            },
            ajax: {
                url: base_url + "prestamos/lstlibros",
                method: "GET",
                dataSrc: "",
            },
            columns: [{
                    data: "art_isbn"
                }, {
                    data: "art_nombre"
                }, {
                    data: "art_cod"
                },
                // {
                //     data: "art_cod"
                // }, {
                //     data: "art_cod"
                // }, {
                //     data: "art_cod"
                // }, {
                //     data: "art_cod"
                // },
            ],
            resonsieve: "true",
            bDestroy: true,
            iDisplayLength: 10,
        });
    });

    function step(e) {
        let btn = $(e);
        let txt = btn.html();
        btn.html(`<div class="spinner-border spinner-border-sm text-light me-2" role="status"><span class="visually-hidden">Loading...</span></div>atrás`);
        $("#spinner").css("display", "flex");
        let ajaxUrl = base_url + "prestamos/first";
        $.get(ajaxUrl, function(data, textStatus, jqXHR) {
            if (textStatus == "success") {
                $("#step2").parent().html(`<div id="step1" class="card"></div>`);
                $("#step2").remove();
                $("#step1").html(data);
            } else {
                $("#spinner").css("display", "none");
            }
        });
    }
</script>