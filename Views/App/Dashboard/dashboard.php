<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="container mt-4">
        <div class="row">
            <div class="col-6 mx-auto text-center">
                <?php
                if ($data['permisos']['perm_r']) {
                ?>
                    <button class="btn btn-primary">read</button>
                <?php } ?>
                <?php
                if ($data['permisos']['perm_w']) {
                ?>
                    <button class="btn btn-primary">write</button>
                <?php } ?>
                <?php
                if ($data['permisos']['perm_u']) {
                ?>
                    <button class="btn btn-primary">update</button>
                <?php } ?>
                <?php
                if ($data['permisos']['perm_d']) {
                ?>
                    <button class="btn btn-primary">delete</button>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?php footerApp('Template/footer_dash', $data) ?>