<?php
class NivelesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function menus(int $idrol)
    {
        $this->intRolid = $idrol;
        $sql = "SELECT * FROM sis_menus 
        WHERE idmenu IN( SELECT DISTINCT (c.idmenu) 
        FROM sis_permisos a INNER JOIN sis_submenus b ON a.idsubmenu = b.idsubmenu 
        LEFT JOIN sis_menus c ON c.idmenu = b.idmenu 
        WHERE a.idrol = '$idrol'  AND a.perm_r = 1 AND c.men_visible = 1 ) ORDER BY men_orden ASC";
        $request = $this->select_all($sql);
        $data = [];
        return $request;
    }

    public function submenus(int $idmenu)
    {
        $idrol = (isset($_SESSION['lnh_r']) && !empty($_SESSION['lnh_r'])) ? $_SESSION['lnh_r'] : 0;
        $sql = "SELECT b.idsubmenu,b.idmenu,b.sub_nombre,b.sub_icono,b.sub_url FROM sis_permisos a
        INNER JOIN sis_submenus b ON a.idsubmenu=b.idsubmenu 
        WHERE b.idmenu = '$idmenu' AND b.sub_visible = 1 AND a.perm_r = 1 AND a.idrol = '$idrol' ORDER BY b.sub_orden ASC";
        $request = $this->select_all($sql);

        $return = [];
        for ($i = 0; $i < count($request); $i++) {
            $return[$i] = [
                'idmenu' => $request[$i]['idmenu'],
                'idsubmenu' => $request[$i]['idsubmenu'],
                'sub_nombre' => (!empty($request[$i]['sub_nombre']) ? ucfirst($request[$i]['sub_nombre']) : ucfirst('sin nombre')),
                'sub_icono' => (!empty($request[$i]['sub_icono']) ? $request[$i]['sub_icono'] : 'fa-solid fa-circle-notch'),
                'sub_url' => (!empty($request[$i]['sub_url']) ? $request[$i]['sub_url'] : '#')
            ];
        }
        return $return;
    }

    public function getPermisosMod($param)
    {
        $idrol = $_SESSION['lnh_r'];
        $sql = "SELECT * FROM sis_permisos a 
        INNER JOIN sis_submenus b ON a.idsubmenu=b.idsubmenu 
        WHERE b.sub_controlador LIKE BINARY '$param' AND a.idrol='$idrol' AND b.sub_visible='1'";
        $request = $this->select($sql);
        return [
            'perm_r' => (!empty($request['perm_r']) ? $request['perm_r'] : '0'),
            'perm_w' => (!empty($request['perm_w']) ? $request['perm_w'] : '0'),
            'perm_u' => (!empty($request['perm_u']) ? $request['perm_u'] : '0'),
            'perm_d' => (!empty($request['perm_d']) ? $request['perm_d'] : '0')
        ];
    }

    public function pertenece($submenu, $menu)
    {
        $sql = "SELECT * FROM sis_submenus WHERE idmenu = '$menu' AND sub_url like BINARY '$submenu'";
        $request = $this->select($sql);
        return $request;
    }
}
