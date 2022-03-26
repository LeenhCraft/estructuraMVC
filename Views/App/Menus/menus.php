<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="tile">
                <?php
                if ($data['permisos']['perm_w'] == 1) {
                ?>
                    <button class="btn btn-primary ft-b" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo Menus
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-12">
            <div class="tile">
                <div class="table-responsive p-1">
                    <table id="sis_menus" class="table table-hover" width="100%">
                        <thead>
                            <tr><th>idmenu</th><th>men_nombre</th><th>men_icono</th><th>men_url_si</th><th>men_url</th><th>men_controlador</th><th>men_orden</th><th>men_visible</th><th>men_fecha</th><th></th></tr>
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
    getModal('mdlMenus');
}
footerApp('Template/footer_dash', $data);
?>