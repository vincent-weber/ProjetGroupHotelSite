<?php
function get_header() {
echo <<<HTL
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">

    <title>Group Hotel</title>
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
HTL;
	
}

function get_footer() {
echo <<<HTL
    <script src="js/main.js"></script>

</body>
</html>
HTL;
	
}

function view($view, $variables = null) {
	get_header();
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
	get_footer();

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

	header("Location: http://".$_SERVER["HTTP_HOST"]."/public".$url); 
}

function unsetTmpVariable(){
	unset($_SESSION["tmp"]);
}


