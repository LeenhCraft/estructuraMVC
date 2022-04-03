<?php

require_once 'Controllers/sys.php';
$primera = new sys();
$data = $primera->first_time();

$controller = ucwords($controller);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$url_excluida = ['Sys', 'Primeraves'];
	for ($i = 0; $i <  count($url_excluida); $i++) {
		if ($controller === $url_excluida[$i]) {
			$controller = 'Error';
			$method = 'notFound';
		}
	}

	if ($data['primera'] == '1' && $controller != 'Web' && $controller != 'Logout') {
		$controller = ucwords('Primeraves');
		$method = 'primeraves';
		$params = '';
	}
}// else if ($_SERVER['REQUEST_METHOD'] == 'POST') {}



// dep($_SERVER['REQUEST_METHOD']);
// dep([$controller,$method],1);

$controllerFile = "Controllers/" . $controller . ".php";

if (file_exists($controllerFile)) {
	require_once($controllerFile);
	$controller = new $controller();
	if (method_exists($controller, $method)) {
		$controller->{$method}($params);
	} else {
		require_once("Controllers/Error.php");
	}
} else {
	require_once("Controllers/Error.php");
}
