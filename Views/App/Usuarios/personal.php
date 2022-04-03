<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="tile">
                <?php
                if ($data['permisos']['perm_w'] == 1) {
                ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar</button>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-12">
            <div class="tile">
                <div class="table-responsive p-1">
                    <table id="tb" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Doc</th>
                                <th>Fecha</th>
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

<?php
if ($data['permisos']['perm_w'] == 1 || $data['permisos']['perm_u'] == 1) {
    getModal('mdlPersonal');
}
footerApp('Template/footer_dash', $data);
?>