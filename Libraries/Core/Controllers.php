<?php
class Controllers
{
	public function __construct()
	{
		$this->views = new Views();
		$this->loadModel();
	}

	public function loadModel()
	{
		$model = get_class($this) . "Model";
		$routClass = "Models/" . $model . ".php";
		if (file_exists($routClass)) {
			require_once($routClass);
			$this->model = new $model();
		}
	}

	public function otro($modelo)
	{
		$model = ucwords($modelo) . "Model";
		$routClass = "Models/" . $model . ".php";
		if (file_exists($routClass)) {
			require_once($routClass);
			$this->other = new $model();
		}
	}

	public function otra_clase($ruta, $file)
	{
		$routClass = "Controllers/" . $ruta . "/" . $file . ".php";
		if (file_exists($routClass)) {
			require_once($routClass);
			$this->oClass = new $file();
		}
	}
}
