<?php headerWeb('header_web', $data); ?>
<!--================Home Banner Area =================-->
<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg banner_part" style="background-image: url('https://technext.github.io/aranoz/img/breadcrumb.png');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>Biblio Carrito</h2>
                        <p>Articulos a reservar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!--================Cart Area =================-->
<section class="cart_area padding_top">
    <div class="container lnh">
        <div class="cart_inner step_1">
            <div class="table-responsive">
                <label class="h4 text-primary"><b>Paso 1</b></label>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Articulos</th>
                            <th class="d-none" scope="col-2">Cantidad</th>
                            <th scope="col-1"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="cart_inner step_2"></div>
    </div>
</section>
<!--================End Cart Area =================-->
<?php footerWeb('footer_web', $data); ?>