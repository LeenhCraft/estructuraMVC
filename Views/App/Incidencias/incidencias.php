<?php headerApp('Template/header_dash', $data); ?>
<div id="step3" class="card">
    <?php require_once __DIR__ . '/step3.php'; ?>
</div>


<?php
if ($data['permisos']['perm_w'] == 1 || $data['permisos']['perm_u'] == 1) {
    //getModal('mdlDevolucion');
}
footerApp('Template/footer_dash', $data);
?>