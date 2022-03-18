<?php
class Web extends Controllers
{
	public function __construct()
	{
		parent::__construct();
	}

	public function web()
	{
		$data['titulo_web'] = "LEENHCRAFT | WEB";
		$data['meta_content'] = "sistemas, nueva cajamarca, pagina web, leenh";
		$data['css'] = ['css/bootstrap.css'];
		$data['js'] = ['js/jquery.min.js', 'js/bootstrap.min.js'];
		$this->views->getView($this, "web", $data);
	}
}
