<?php
class SysModel extends Mysql
{
	public function __construct()
	{
		parent::__construct();
	}
    
    public function first_time($id)
	{
		$id = intval($_SESSION['lnh_id']);
		$sql = "SELECT usu_primera as primera FROM sis_usuarios WHERE usu_id  = '$id'";
		$request = $this->select($sql);
		return $request;
	}

	public function public_first_time($id)
	{
		$sql = "SELECT usu_primera as primera FROM web_usuarios WHERE idwebusuario = '$id'";
		$request = $this->select($sql);
		return $request;
	}
}
