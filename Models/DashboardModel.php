<?php
class DashboardModel extends Mysql
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

	public function add($cod, $title, $des, $stock, $idtipoart)
	{
		$sql = "SELECT * FROM bib_articulos WHERE art_cod = '$cod'";
		$request = $this->select($sql);

		if (empty($request)) {
			$sql = "INSERT INTO bib_articulos (art_cod, art_nombre, art_descri, art_resumen, idtipoarticulo, art_stock) VALUES (?,?,?,?,?,?)";
			$arrData = array($cod, $title, $des, $des, $idtipoart, $stock);
			$response = $this->insert($sql, $arrData);
			if ($response > 0) {
				$return['status'] = true;
				$return['icon'] = "";
				$return['data'] = $response;
			} else {
				$return['status'] = false;
				$return['icon'] = "danger";
				$return['data'] = 'Ocurrio un error al registrarlo.';
			}
		} else {
			$return['status'] = false;
			$return['icon'] = "warning";
			$return['data'] = 'El libro ya esta registrado.';
		}

		return $return;
	}
}
