<?php headerApp('Template/header_dash', $data); ?>
<div id="step6" class="card">
    <?php require_once __DIR__ . '/step6.php'; ?>
</div>


<?php
if ($data['permisos']['perm_w'] == 1 || $data['permisos']['perm_u'] == 1) {
    //getModal('a');
}
footerApp('Template/footer_dash', $data);
?>