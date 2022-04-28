<?php headerApp('Template/header_dash', $data); ?>
<div class="card">
    <div class="card-header">
        <?php
        if ($data['permisos']['perm_w'] == 1) {
        ?>
            <button class="btn btn-primary ft-b" type="button" onclick="openModal();">
                <i class='bx bx-plus-circle'></i> Nuevo Rol
            </button>
        <?php
        }
        ?>
    </div>
    <div class="table-responsive text-nowrap mb-4">
        <table id="sis_rol" class="table table-hover" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cod</th>
                    <th>Estado</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php
if ($data['permisos']['perm_w'] == 1 || $data['permisos']['perm_u'] == 1) {
    getModal('mdlRol', $data);  
}
footerApp('Template/footer_dash', $data);
?>