<?php
$pe_u = $data = [];
if (file_exists("Controllers/Sys.php")) {
	require_once("Controllers/Sys.php");
	$bp = new Sys();
	$data = $bp->first_time();
	$pe_u = $bp->publi_first();
} else {
	require_once("Controllers/Error.php");
}

$controller = ucwords($controller);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$url_excluida = ['Sys', 'Primeraves'];
	for ($i = 0; $i <  count($url_excluida); $i++) {
		if ($controller === $url_excluida[$i]) {
			$controller = 'Error';
			$method = 'notFound';
		}
	}

	if (isset($_SESSION['lnh_id']) && $data['primera'] == '1' && $controller != 'Web' && $controller != 'Logout' && $method != 'web') {
		$controller = ucwords('Primeraves');
		$method = 'primeraves';
		$params = '';
	}

	if (isset($_SESSION['pe_u']) && $pe_u['primera'] == '1' && $controller != 'Web' && $controller != 'Logout' && $method != 'web') {
		$controller = ucwords('web');
		$method = 'password';
		$params = '';
	}
} // else if ($_SERVER['REQUEST_METHOD'] == 'POST') {}
// dep($_SERVER['REQUEST_METHOD']);
// dep([$controller, $method], 1);

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
