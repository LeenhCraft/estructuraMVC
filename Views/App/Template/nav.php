<?php
$url = !empty($_GET['url']) ? $_GET['url'] : 'web/web';
$arrUrl = explode("/", $url);
// $ctrl = $arrUrl[0];
$ctrl = (isset($arrUrl[1])) ? $arrUrl[0] . '/' . $arrUrl[1] : $arrUrl[0];
$expand = $active = '';
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/dashboard" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2"><?php echo NOMBRE_EMPRESA; ?></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php
        if (!empty(menus())) {
            foreach (menus() as $row) {
                if ($row['men_url_si'] == 1) {
                    $active = ($row['men_url'] == $ctrl) ? 'active' : '';
        ?>
                    <!-- Dashboard -->
                    <li class="menu-item <?= $active; ?>">
                        <a href="<?= '/' . $row['men_url']; ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx <?= $row['men_icono']; ?>"></i>
                            <div data-i18n="Analytics"><?= $row['men_nombre']; ?></div>
                        </a>
                    </li>
                <?php
                } else {
                    $submenus = submenus($row['idmenu']);
                    $expand = (pertenece($ctrl, $row['idmenu'])) ? 'open' : '';
                ?>
                    <li class="menu-item <?= $expand; ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle" href="#">
                            <i class="menu-icon tf-icons bx <?= $row['men_icono']; ?>"></i>
                            <div data-i18n="Layouts"><?= $row['men_nombre']; ?></div>
                        </a>

                        <ul class="menu-sub">
                            <?php
                            foreach ($submenus as $key) {
                                $active = ($key['sub_url'] == $ctrl) ? 'active' : '';
                            ?>
                                <li class="menu-item <?= $active; ?>">
                                    <a href="<?= '/' . $key['sub_url']; ?>" class="menu-link">
                                        <div data-i18n="<?= $key['sub_nombre']; ?>">
                                            <i class="menu-icon tf-icons bx <?= $key['sub_icono']; ?>"></i>
                                            <?= $key['sub_nombre']; ?>
                                        </div>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
            <?php
                }
            }
        } else {
            ?>
            <li class="menu-item">
                <a href="index.html" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Sin menus</div>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
</aside>