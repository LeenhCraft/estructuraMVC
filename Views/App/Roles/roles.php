<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="tile">
                <?php
                if ($data['permisos']['perm_w'] == 1) {
                ?>
                    <button class="btn btn-primary ft-b" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo Rol
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-12">
            <div class="tile">
                <div class="table-responsive p-1">
                    <table id="sis_rol" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>idrol</th>
                                <th>rol_nombre</th>
                                <th>rol_cod</th>
                                <th>rol_descripcion</th>
                                <th>rol_estado</th>
                                <th>rol_fecha</th>
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
getModal('mdlRol', $data);
footerApp('Template/footer_dash', $data);
?>