<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="index.html"><?php echo NOMBRE_EMPRESA; ?></a>
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
    <ul class="app-menu">
        <?php
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
            ?>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon <?= $row['men_icono']; ?>"></i>
                        <span class="app-menu__label"><?= $row['men_nombre']; ?></span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                        foreach (submenus($row['idmenu']) as $key) {
                        ?>
                            <li><a class="treeview-item" href="<?= $key['sub_url']; ?>"><i class="icon <?= $key['sub_icono']; ?> mr-2"></i> <?= $key['sub_nombre']; ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
        <?php
            }
        }
        ?>
    </ul>
</aside>