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
        WHERE a.idrol = '$idrol' AND c.men_visible = 1 ) ORDER BY men_orden ASC";
        $request = $this->select_all($sql);
        $data = [];
        return $request;
    }

    public function submenus(int $idmenu)
    {
        $sql = "SELECT * FROM sis_submenus WHERE idmenu = '$idmenu' AND sub_visible = 1 ORDER BY sub_orden ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getPermisosMod($idmod)
    {
        $idusu = $_SESSION['nmr'];
        // limitar permisos a solo el modulo actual
        $sql = "SELECT
                    c.mod_cod AS modulo,
                    a.perm_r,
                    a.perm_w,
                    a.perm_u,
                    a.perm_d
                FROM
                    sis_permisos a
                INNER JOIN sis_rol b ON
                    a.idrol = b.idrol
                INNER JOIN sis_modulo c ON
                    a.idmodulo = c.idmodulo
                INNER JOIN sis_usuarios d ON
                    b.idrol = d.idrol
                WHERE
                    c.mod_cod LIKE BINARY '{$idmod}'
                AND
                    d.usu_id = '{$idusu}'";
        $request = $this->select($sql);
        // $arrPermisos = array();
        // for ($i = 0; $i < count($request); $i++) {
        //     $arrPermisos[$request[$i]['idmodulo']] = $request[$i];
        // }
        // return $arrPermisos;
        return $request;
    }
}
