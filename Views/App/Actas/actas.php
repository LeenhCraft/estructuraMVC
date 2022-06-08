<?php headerApp('Template/header_dash', $data); ?>
<div class="card">
    <div id="spinner" class="divLoading">
        <div>
            <img src="<?= media() . 'img/loading.svg'; ?>" alt="Loading">
        </div>
    </div>
    <div class="card-header px-md-5 text-dark">
        <div class="row pb-md-5 border-bottom">
            <!-- titulo -->
            <div class="col-12 text-center py-3 mb-4">
                <label class="text-primary fw-bold h3 p-0 m-0">Generar Acta</label>
            </div><!-- end titulo -->
            <div class="col-md-6">
                <button type="button" class="btn btn-outline-primary btn-sm">Buscar Don/Pro</button>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 mb-3 text-end">
                        <label class="text-start">Código Acta:</label>
                        <label class="h5 m-0 text-primary fw-bold cod_ficha">12345</label>
                    </div>
                    <div class="col-md-12 text-end">
                        <label class="me-2">Fecha:</label><label class="text-primary fw-bold"><?php echo date('d/m/Y'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerApp('Template/footer_dash', $data); ?>