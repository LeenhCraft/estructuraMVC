<?php headerApp('Template/header_dash', $data); ?>

<main class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="tile">
                <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Agregar</button>
            </div>
        </div>
        <div class="col-12">
            <div class="tile">
                <div class="table-responsive p-1">
                    <table id="tb" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php footerApp('Template/footer_dash', $data) ?>