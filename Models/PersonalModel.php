<?php
class PersonalModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function lstPersonal()
    {
        $sql = "SELECT idpersona as id, per_dni as dni, per_nombre as nombre,per_estado as estado, per_fecha as fecha FROM bib_personal ORDER BY idpersona DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertar($dni, $nombre, $cel, $dir, $estado = 1)
    {
        $return = [];
        $sql = "SELECT * FROM bib_personal WHERE per_dni = '{$dni}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO bib_personal(per_dni,per_nombre,per_celular,per_direc,per_estado) VALUES(?,?,?,?,?)";
            $arrData = array($dni, $nombre, $cel, $dir, $estado);
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

    public function actualizar($id, $dni, $nombre, $cel, $dir, $estado)
    {
        $sql = "SELECT * FROM bib_personal WHERE per_nombre LIKE'{$nombre}' AND idpersona != $id";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE bib_personal SET per_dni=?,per_nombre=?, per_celular=?,per_direc=?, per_estado=? WHERE idpersona = $id";
            $arrData = array($dni, $nombre, $cel, $dir, $estado);
            $request = $this->update($sql, $arrData);
        } else {
            $return['status'] = false;
            $return['data'] = 'El nombre que esta ingresando ya esta registrado.';
        }
        return $request;
    }

    public function persona(int $id)
    {
        $sql = "SELECT idpersona as nmr,per_dni as dni, per_nombre as nombre, per_celular as cel, per_direc as dir, per_estado as estado FROM bib_personal WHERE idpersona = $id";
        $request = $this->select($sql);
        return $request;
    }

    public function eliminar(int $id)
    {
        $sql = "SELECT * FROM bib_personal WHERE idpersona = $id";
        $request = $this->select($sql);
        if (!empty($request)) {
            $sql = "DELETE FROM bib_personal WHERE idpersona = $id";
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

    public function perxuser($id)
    {
        $sql = "SELECT * FROM sis_usuarios WHERE idpersona = '$id'";
        $request = $this->select($sql);
        if (empty($request)) {
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'No se puede eliminar porque hay un usuario asociado a este registro.';
        }
        return $return;
    }
}
