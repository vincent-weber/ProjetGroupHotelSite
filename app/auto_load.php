<?php
session_start();

spl_autoload_register(function ($class_name) {
	//echo __DIR__;

	if (file_exists(__DIR__ . "/" . $class_name . ".php")) {
		require_once __DIR__ . "/" . $class_name . ".php";
	}
	else if (file_exists(dirname(__DIR__, 1) . "/controllers/" . $class_name . ".php")) {
		require_once dirname(__DIR__, 1) . "/controllers/" . $class_name . '.php';
	}
	else if (file_exists(dirname(__DIR__, 1) . "/models/" . $class_name . ".php")) {
		require_once dirname(__DIR__, 1) . "/models/" . $class_name . '.php';
	}
});

require_once ("functions.php");