<?php
class Views
{
	function getView($controller, $view, $data = "")
	{
		if (is_object($controller)) {
			$controller = get_class($controller);
		}
		// if ($controller == "Web") {
		// 	$view = "Views/" . $view . ".php";
		// } else {
		$view = "Views/" . $controller . "/" . $view . ".php";
		// }
		require_once $view;
	}
}
