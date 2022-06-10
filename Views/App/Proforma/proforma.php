<?php headerApp('Template/header_dash', $data); ?>
<div id="step7" class="card">
    <?php require_once __DIR__ . '/step7.php'; ?>
</div>


<?php
if ($data['permisos']['perm_w'] == 1 || $data['permisos']['perm_u'] == 1) {
    //getModal('a');
}
footerApp('Template/footer_dash', $data);
?>