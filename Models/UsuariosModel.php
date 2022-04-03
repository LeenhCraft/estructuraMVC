<?php
class UsuariosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function lstUser()
    {
        $sql = "SELECT a.usu_id as id,a.usu_usuario as usu,a.usu_estado as estado,b.rol_nombre as rol FROM sis_usuarios a INNER JOIN sis_rol b ON b.idrol=a.idrol";
        $request = $this->select_all($sql);
        return $request;
    }

    public function lstPersonal()
    {
        $sql = "SELECT idpersona as id, per_dni as dni, per_nombre as nombre, per_fecha as fecha FROM bib_personal";
        $request = $this->select_all($sql);
        return $request;
    }
}
