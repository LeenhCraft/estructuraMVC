<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="tile">
                <?php
                if ($data['permisos']['perm_w'] == 1) {
                ?>
                    <button class="btn btn-primary ft-b" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo Permisos
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-12">
            <div class="tile">
                <div class="table-responsive p-1">
                    <table id="sis_permisos" class="table table-hover" width="100%">
                        <thead>
                            <tr><th>idpermisos</th><th>idrol</th><th>idsubmenu</th><th>perm_r</th><th>perm_w</th><th>perm_u</th><th>perm_d</th><th></th></tr>
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
    getModal('mdlPermisos');
}
footerApp('Template/footer_dash', $data);
?>