<?php 
class MenusModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT * FROM sis_menus";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_menus WHERE idmenu = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($men_nombre,$men_icono,$men_url_si,$men_url,$men_controlador,$men_orden,$men_visible,$men_fecha)
    {
        $return =$request= [];
        //$sql = "SELECT * FROM sis_menus WHERE idmenu = 'idmenu'";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO sis_menus(men_nombre,men_icono,men_url_si,men_url,men_controlador,men_orden,men_visible,men_fecha) VALUES (?,?,?,?,?,?,?,?)";
            $arrData = array($men_nombre,$men_icono,$men_url_si,$men_url,$men_controlador,$men_orden,$men_visible,$men_fecha);
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

    public function actualizar($idmenu,$men_nombre,$men_icono,$men_url_si,$men_url,$men_controlador,$men_orden,$men_visible,$men_fecha)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE sis_menus SET men_nombre=?,men_icono=?,men_url_si=?,men_url=?,men_controlador=?,men_orden=?,men_visible=?,men_fecha=? WHERE idmenu =$idmenu";
            $arrData = array($men_nombre,$men_icono,$men_url_si,$men_url,$men_controlador,$men_orden,$men_visible,$men_fecha);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function eliminar($idmenu)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE idpersona = $id";
        //$request = $this->select($sql);
        if (!empty($request)) {
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
            $return['data'] = 'No se encontraron registros.';
        }
        return $return;
    }
}

?>