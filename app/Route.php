<?php

class Route {


	public static $routeFind = 0;

	public static function get($url, $route) {
		if ($url == urldecode($_SERVER["REQUEST_URI"])) {

			$splited = explode("@", $route);
			$controller = new $splited[0]();
			$function = $splited[1];
			call_user_func_array(array($controller, $function),array());
			self::$routeFind++;
		}
		else {
				$parameters = [];
				$currentUrl = urldecode($_SERVER["REQUEST_URI"]);
				$currentUrlExploded = explode("/",$currentUrl);
				$matchUrlExploded = explode("/",$url);
				$tmpUrl = "";
				if(count($matchUrlExploded) === count($currentUrlExploded)){
					for($index = 1; $index < count($matchUrlExploded); $index++){
						$tmpUrl .= '/';
						if(strpos($matchUrlExploded[$index], "{") !== false){
							array_push($parameters,$currentUrlExploded[$index]);
							$tmpUrl .= $currentUrlExploded[$index];
						}
						else{
							$tmpUrl .= $matchUrlExploded[$index];
						}
					}
				}

				if($tmpUrl === $currentUrl){
					$splited = explode("@", $route);
					$controller = new $splited[0]();
					$function = $splited[1];
					call_user_func_array(array($controller, $function), $parameters);
					self::$routeFind++;
				}
		}
	}

	public static function post($url,$route){
		if ($url == urldecode($_SERVER["REQUEST_URI"])) {


			$splited = explode("@", $route);
			$controller = new $splited[0]();
			$function = $splited[1];
			call_user_func_array(array($controller, $function), array(new PostRequest));
			self::$routeFind++;
		}
	}

	public static function end(){
		if(self::$routeFind === 0 )
			return view("404");
		else if(self::$routeFind > 1)
			throw new Exception("Many routes matches");
	}

}

