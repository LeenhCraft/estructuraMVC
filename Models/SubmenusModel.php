<?php
class SubmenusModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT a.idsubmenu as id, a.sub_nombre as submenu, a.sub_url as url, a.sub_orden as orden,a.sub_visible as ver, b.men_nombre as menu, a.sub_icono as icono, b.men_icono as icono2 FROM sis_submenus a 
        INNER JOIN 
        sis_menus b ON b.idmenu=a.idmenu
        ORDER BY a.idsubmenu desc";
        $request = $this->select_all($sql);
        return $request;
    }

    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_submenus WHERE idsubmenu = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($idmenu, $sub_nombre, $sub_url, $sub_controlador, $sub_icono, $sub_orden, $sub_visible)
    {
        $return = $request = [];
        //$sql = "SELECT * FROM sis_submenus WHERE idsubmenu = 'idsubmenu'";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO sis_submenus(idmenu,sub_nombre,sub_url,sub_controlador,sub_icono,sub_orden,sub_visible) VALUES (?,?,?,?,?,?,?)";
            $arrData = array($idmenu, $sub_nombre, $sub_url, $sub_controlador, $sub_icono, $sub_orden, $sub_visible);
            $response = $this->insert($sql, $arrData);
            if ($response > 0) {
                $return['status'] = true;
                $return['data'] = '';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al intentar registrar el personal.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'El DNI que esta tratando de ingresar ya esta registrado.';
        }
        return $return;
    }

    public function actualizar($idsubmenu, $sub_nombre, $sub_url, $sub_controlador, $sub_icono, $sub_orden, $sub_visible)
    {
        $request = [];
        $sql = "SELECT * FROM sis_submenus WHERE sub_nombre LIKE'{$sub_nombre}' AND idsubmenu != $idsubmenu";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE sis_submenus SET sub_nombre=?,sub_url=?,sub_controlador=?,sub_icono=?,sub_orden=?,sub_visible=? WHERE idsubmenu =$idsubmenu";
            $arrData = array($sub_nombre, $sub_url, $sub_controlador, $sub_icono, $sub_orden, $sub_visible);
            $request = $this->update($sql, $arrData);
            $return['status'] = $request;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $return;
    }

    public function eliminar($idsubmenu)
    {
        $request = [];
        $sql = "SELECT * FROM sis_permisos WHERE idsubmenu = $idsubmenu";
        $request = $this->select($sql);
        if (empty($request)) {
            $sql = "DELETE FROM sis_submenus WHERE idsubmenu = $idsubmenu";
            $arrData = array(0);
            $request = $this->delete($sql, $arrData);
            if ($request) {
                $return['status'] = true;
                $return['data'] = 'El registro fue eliminado!';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al tratar de eliminar el registro.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'No se puede eliminar un registro asociados a otros.';
        }
        return $return;
    }

    public function menus()
    {
        $sql = "SELECT idmenu as id, men_nombre as nombre FROM sis_menus ORDER BY men_orden ASC";
        $request = $this->select_all($sql);
        return $request;
    }
}
