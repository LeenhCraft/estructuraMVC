<?php
class PermisosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT
                    a.idpermisos AS id,
                    d.rol_nombre AS rol,
                    c.men_nombre AS menu,
                    b.sub_nombre AS submenu,
                    a.perm_r AS r,
                    a.perm_w AS w,
                    a.perm_u AS u,
                    a.perm_d AS d
                FROM
                    sis_permisos a
                INNER JOIN sis_submenus b ON
                    a.idsubmenu = b.idsubmenu
                INNER JOIN sis_menus c ON
                    c.idmenu = b.idmenu
                INNER JOIN sis_rol d ON
                    a.idrol = d.idrol
                ORDER BY
                    a.idpermisos
                DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function buscar($id)
    {
        $sql = "SELECT * FROM sis_permisos WHERE idpermisos = '$id'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertar($idrol, $idsubmenu, $perm_r, $perm_w, $perm_u, $perm_d)
    {
        $return = $request = [];
        $sql = "SELECT * FROM sis_permisos WHERE idrol = '$idrol' AND idsubmenu = '$idsubmenu'";
        $request = $this->select_all($sql);
        $return['status'] = false;
        $return['data'] = 'error del sistema.';
        if (empty($request)) {
            $sql = "INSERT INTO sis_permisos(idrol,idsubmenu,perm_r,perm_w,perm_u,perm_d) VALUES (?,?,?,?,?,?)";
            $arrData = array($idrol, $idsubmenu, $perm_r, $perm_w, $perm_u, $perm_d);
            $response = $this->insert($sql, $arrData);
            if ($response > 0) {
                $return['status'] = true;
                $return['data'] = 'Se registro correctamente.';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al intentar registrar.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'Ya tiene asigando el submenu al rol actual.';
        }
        return $return;
    }

    public function actualizar($idpermisos, $idrol, $idsubmenu, $perm_r, $perm_w, $perm_u, $perm_d)
    {
        $request = [];
        //$sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        //$request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE sis_permisos SET idrol=?,idsubmenu=?,perm_r=?,perm_w=?,perm_u=?,perm_d=? WHERE idpermisos =$idpermisos";
            $arrData = array($idrol, $idsubmenu, $perm_r, $perm_w, $perm_u, $perm_d);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function eliminar($idpermisos)
    {
        $request = [];
        $sql = "SELECT * FROM sis_permisos WHERE idpermisos = $idpermisos";
        $request = $this->select($sql);
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

    public function roles()
    {
        $sql = "SELECT idrol as id, rol_nombre as nombre FROM sis_rol";
        $request = $this->select_all($sql);
        return $request;
    }

    public function submenus()
    {
        $sql = "SELECT idsubmenu as id, sub_nombre as nombre FROM sis_submenus";
        $request = $this->select_all($sql);
        return $request;
    }

    public function up_perm($id, $ac)
    {
        $request = [];
        $sql = "SELECT * FROM sis_permisos WHERE idpermisos = '$id'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $sql = "UPDATE sis_permisos SET $ac WHERE idpermisos ='$id'";
            $arrData = [];
            $request = $this->update($sql, $arrData);
            $return['status'] = $request;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'No existe el permiso.';
        }
        return $return;
    }
}
