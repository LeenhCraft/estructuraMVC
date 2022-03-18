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
		$this->views->getView($this, "web", $data);
	}
}
