<?php
class SysModel extends Mysql
{
	public function __construct()
	{
		parent::__construct();
	}
    
    public function first_time()
	{
		$id = intval($_SESSION['lnh_id']);
		$sql = "SELECT usu_primera as primera FROM sis_usuarios WHERE usu_id  = '$id'";
		$request = $this->select($sql);
		return $request;
	}
}
