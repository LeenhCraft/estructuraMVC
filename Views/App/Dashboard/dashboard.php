<?php headerApp('Template/header_dash', $data); ?>
<main class="app-content">
    <div class="mt-4">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Users</h4>
                        <p><b>5</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon">
                    <i class="icon fa-solid fa-thumbs-up"></i>
                    <div class="info">
                        <h4>Likes</h4>
                        <p><b>25</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon">
                    <i class="icon fa-solid fa-copy"></i>
                    <div class="info">
                        <h4>Uploades</h4>
                        <p><b>10</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4>Stars</h4>
                        <p><b>500</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile col-12 col-md-4">
            <div class="info">
                
                <h4><?= getName($_SESSION['lnh_id'])['nombre'] ?></h4>
                <h5><?= getName($_SESSION['lnh_id'])['rol'] ?></h5>
            </div>
        </div>
    </div>
</main>
<?php footerApp('Template/footer_dash', $data) ?>