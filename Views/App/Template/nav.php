<?php
$url = !empty($_GET['url']) ? $_GET['url'] : 'web/web';
$arrUrl = explode("/", $url);
$ctrl = $arrUrl[0];
$expand = $active = '';
?>
<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href=""><?php echo NOMBRE_EMPRESA; ?></a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-cog fa-lg mr-2"></i>Settings</a></li>
                <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-user fa-lg mr-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="logout"><i class="fa fa-sign-out fa-lg mr-2"></i>Salir</a></li>
            </ul>
        </li>
    </ul>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">nombre</p>
            <p class="app-sidebar__user-designation">rol</p>
        </div>
    </div>
    <ul class="app-menu text-white">
        <?php
        if (!empty(menus())) {
            foreach (menus() as $row) {
                if ($row['men_url_si'] == 1) {
        ?>
                    <li>
                        <a class="app-menu__item" href="<?= $row['men_url']; ?>">
                            <i class="app-menu__icon <?= $row['men_icono']; ?>"></i>
                            <span class="app-menu__label"><?= $row['men_nombre']; ?></span>
                        </a>
                    </li>
                <?php
                } else {
                    $submenus = submenus($row['idmenu']);
                    $expand = (pertenece($ctrl, $row['idmenu'])) ? 'is-expanded' : '';
                ?>
                    <li class="treeview <?= $expand; ?>">
                        <a class="app-menu__item" href="#" data-toggle="treeview">
                            <i class="app-menu__icon <?= $row['men_icono']; ?>"></i>
                            <span class="app-menu__label"><?= $row['men_nombre']; ?></span>
                            <i class="treeview-indicator fa fa-angle-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            foreach ($submenus as $key) {
                                $active = ($key['sub_url'] == $ctrl) ? 'active' : '';
                            ?>
                                <li><a class="treeview-item <?= $active; ?>" href="<?= BASE_URL . $key['sub_url']; ?>"><i class="icon <?= $key['sub_icono']; ?> mr-2"></i> <?= $key['sub_nombre']; ?></a></li>
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
            <li>
                <a class="app-menu__item" href="#">
                    <i class="app-menu__icon fa-solid fa-magnifying-glass"></i>
                    <span class="app-menu__label">Sin menus</span>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
</aside>