<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="tile">
                <?php
                if ($data['permisos']['perm_w'] == 1) {
                ?>
                    <button class="btn btn-primary ft-b" type="button" onclick="openModal();">
                        <i class="fas fa-plus-circle"></i> Nuevo
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-12">
            <div class="tile">
                <div class="table-responsive p-1">
                    <table id="sis_submenus" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">N°</th>
                                <th width="20%">Menu</th>
                                <th width="20%">Sub menu</th>
                                <th>Url</th>
                                <th>Orden</th>
                                <th>Visible</th>
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
    getModal('mdlSubmenus');
}
footerApp('Template/footer_dash', $data);
?>