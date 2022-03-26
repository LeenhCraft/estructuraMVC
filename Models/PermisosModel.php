<?php 
class PermisosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT * FROM sis_permisos";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_permisos WHERE idpermisos = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($idrol,$idsubmenu,$perm_r,$perm_w,$perm_u,$perm_d)
    {
        $return =$request= [];
        //$sql = "SELECT * FROM sis_permisos WHERE idpermisos = 'idpermisos'";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO sis_permisos(idrol,idsubmenu,perm_r,perm_w,perm_u,perm_d) VALUES (?,?,?,?,?,?)";
            $arrData = array($idrol,$idsubmenu,$perm_r,$perm_w,$perm_u,$perm_d);
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

    public function actualizar($idpermisos,$idrol,$idsubmenu,$perm_r,$perm_w,$perm_u,$perm_d)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE sis_permisos SET idrol=?,idsubmenu=?,perm_r=?,perm_w=?,perm_u=?,perm_d=? WHERE idpermisos =$idpermisos";
            $arrData = array($idrol,$idsubmenu,$perm_r,$perm_w,$perm_u,$perm_d);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function eliminar($idpermisos)
    {
        $request= [];
        //$sql = "SELECT * FROM bib_personal WHERE idpersona = $id";
        //$request = $this->select($sql);
        if (!empty($request)) {
            $sql = "DELETE FROM sis_permisos WHERE idpermisos = $idpermisos";
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