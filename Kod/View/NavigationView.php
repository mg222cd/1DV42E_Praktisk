<?php
namespace View;

/**
* Helper class for MainController which action/scenario to be shown.
*
* @return active action if any of declared here, else sign in page
*/
class NavigationView{
	private static $action = 'action';
	public static $actionSearch = 'search'; 
	public static $actionStart = 'start';
	public static $actionForecast = 'forecast';

	public static function getAction(){
		if (isset($_GET[self::$action])){
			return $_GET[self::$action];
		}
		elseif (isset($_GET[self::$actionSearch])){
			return self::$actionSearch;
			//return $_GET[self::$actionSearch];
		}
		elseif (isset($_GET[self::$actionForecast])){
			return self::$actionForecast;
			//return $_GET[self::$actionForecast];
		}
		//if no action is set, startaction is returned
		return self::$actionStart;
	}
}