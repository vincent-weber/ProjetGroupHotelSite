<?php




function view($view, $variables = null) {
	if ($variables !== null) {
		extract($variables);
	}

	if(isset($_SESSION["tmp"])){
		foreach($_SESSION["tmp"] as $keys => $value){
			$$keys = $value;
			extract($$keys);			
		}
	}

	include dirname(__DIR__, 1) . "/views/" . $view . ".php";

	unsetTmpVariable();
}

function unsetTableParams($value){
	unset($value->table);
	unset($value->primaryKey);
}


function requireAccessLevel($accessLevels){
	// TODO : Return 403 forbiden access if level is needed
}


function redirect($url, $params = null){
	if($params !== null){
		$_SESSION["tmp"] = [];
		foreach($params as $key => $value){
			array_push($_SESSION["tmp"], [$key => $value]);
		}
	}

	header("Location: http://".$_SERVER["HTTP_HOST"].$url); 
}

function unsetTmpVariable(){
	unset($_SESSION["tmp"]);
}


function component($component){
	include("../views/components/".$component.".php");
}
