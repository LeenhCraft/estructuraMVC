<?php
class PrimeravesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function verificar()
    {
        $id = isset($_SESSION['lnh_id']) ? intval($_SESSION['lnh_id']) : '0';
        $sql = "SELECT * FROM sis_usuarios WHERE usu_id = $id AND usu_primera = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function upd_pass($pass)
    {
        $id = isset($_SESSION['lnh_id']) ? intval($_SESSION['lnh_id']) : '0';
        $sql = "UPDATE sis_usuarios SET usu_pass = ?, usu_primera = ? WHERE usu_id = $id";
        $arrData = [$pass, 0];
        $request = $this->update($sql, $arrData);
        $return['status'] = $request;
        $return['data'] = '';
        return $return;
    }
}
