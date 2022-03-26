<?php 
class SubmenusModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT * FROM sis_submenus";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_submenus WHERE idsubmenu = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($idmenu,$sub_nombre,$sub_url,$sub_controlador,$sub_icono,$sub_orden,$sub_visible,$sub_fecha)
    {
        $return =$request= [];
        //$sql = "SELECT * FROM sis_submenus WHERE idsubmenu = 'idsubmenu'";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO sis_submenus(idmenu,sub_nombre,sub_url,sub_controlador,sub_icono,sub_orden,sub_visible,sub_fecha) VALUES (?,?,?,?,?,?,?,?)";
            $arrData = array($idmenu,$sub_nombre,$sub_url,$sub_controlador,$sub_icono,$sub_orden,$sub_visible,$sub_fecha);
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

    public function actualizar($idsubmenu,$idmenu,$sub_nombre,$sub_url,$sub_controlador,$sub_icono,$sub_orden,$sub_visible,$sub_fecha)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE sis_submenus SET idmenu=?,sub_nombre=?,sub_url=?,sub_controlador=?,sub_icono=?,sub_orden=?,sub_visible=?,sub_fecha=? WHERE idsubmenu =$idsubmenu";
            $arrData = array($idmenu,$sub_nombre,$sub_url,$sub_controlador,$sub_icono,$sub_orden,$sub_visible,$sub_fecha);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function eliminar($idsubmenu)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE idpersona = $id";
        //$request = $this->select($sql);
        if (!empty($request)) {
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
            $return['data'] = 'No se encontraron registros.';
        }
        return $return;
    }
}

?>