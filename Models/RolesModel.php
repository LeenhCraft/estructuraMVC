<?php 
class RolesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT * FROM sis_rol";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_rol WHERE idrol = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($rol_nombre,$rol_cod,$rol_descripcion,$rol_estado)
    {
        $return =$request= [];
        //$sql = "SELECT * FROM sis_rol WHERE idrol = 'idrol'";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO sis_rol(rol_nombre,rol_cod,rol_descripcion,rol_estado) VALUES (?,?,?,?)";
            $arrData = array($rol_nombre,$rol_cod,$rol_descripcion,$rol_estado);
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

    public function actualizar($idrol,$rol_nombre,$rol_cod,$rol_descripcion,$rol_estado)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE sis_rol SET rol_nombre=?,rol_cod=?,rol_descripcion=?,rol_estado=? WHERE idrol =$idrol";
            $arrData = array($rol_nombre,$rol_cod,$rol_descripcion,$rol_estado);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function eliminar($idrol)
    {
        $request= [];
        $sql = "SELECT * FROM sis_rol WHERE idrol = $idrol";
        $request = $this->select($sql);
        if (!empty($request)) {
            $sql = "DELETE FROM sis_rol WHERE idrol = $idrol";
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
