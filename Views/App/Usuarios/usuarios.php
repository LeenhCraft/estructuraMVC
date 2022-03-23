<?php headerApp('Template/header_dash', $data); ?>

<div class="app-content container">
    <div class="col-6 mx-auto">
        <?php
        dep($data['permisos']);
        if ($data['permisos']['perm_r'] != 1) {

            dep('!=1');
        }
        ?>
    </div>
</div>

<?php footerApp('Template/footer_dash', $data) ?>