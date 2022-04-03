<?php
class MenusModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT * FROM sis_menus ORDER BY men_orden ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_menus WHERE idmenu = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($men_nombre, $men_icono, $men_url_si, $men_url, $men_controlador, $men_orden, $men_visible)
    {
        $return = $request = [];
        //$sql = "SELECT * FROM sis_menus WHERE idmenu = 'idmenu'";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO sis_menus(men_nombre,men_icono,men_url_si,men_url,men_controlador,men_orden,men_visible) VALUES (?,?,?,?,?,?,?)";
            $arrData = array($men_nombre, $men_icono, $men_url_si, $men_url, $men_controlador, $men_orden, $men_visible);
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

    public function actualizar($idmenu, $men_nombre, $men_icono, $men_url_si, $men_url, $men_controlador, $men_orden, $men_visible)
    {
        $request = [];
        $sql = "SELECT * FROM sis_menus WHERE men_nombre LIKE'{$men_nombre}' AND idmenu != $idmenu";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE sis_menus SET men_nombre=?,men_icono=?,men_url_si=?,men_url=?,men_controlador=?,men_orden=?,men_visible=? WHERE idmenu =$idmenu";
            $arrData = array($men_nombre, $men_icono, $men_url_si, $men_url, $men_controlador, $men_orden, $men_visible);
            $request = $this->update($sql, $arrData);
            $return['status'] = $request;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $return;
    }

    public function eliminar($idmenu)
    {
        $request = [];
        $sql = "SELECT * FROM sis_submenus WHERE idmenu = $idmenu";
        $request = $this->select($sql);
        if (empty($request)) {
            $sql = "DELETE FROM sis_menus WHERE idmenu = $idmenu";
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
}
