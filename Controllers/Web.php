<?php
class Web extends Controllers
{
	public function __construct()
	{
		// session_start();
		parent::__construct();
	}

	public function web()
	{
		$data['titulo_web'] = "LEENHCRAFT | WEB";
		$data['meta_content'] = "sistemas, nueva cajamarca, pagina web, leenh";
		// $data['css'] = ['css/bootstrap.css'];
		// $data['js'] = ['js/jquery.min.js', 'js/bootstrap.min.js'];
		$this->views->getView('Web', "web", $data);
	}

	public function consultar($parametro)
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
			$dni = intval(strClean($parametro));
			$response = consultaDNI($dni);
			echo $response;
		}
		die();
	}
}
