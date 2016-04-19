<?php
namespace View;

/**
* Helper class for MainController which action/scenario to be shown.
*
* @return active action if any of declared here, else sign in page
*/
class NavigationView{
	private static $action = 'action';
	public static $actionShowForecast = 'showForecast';
	//public static $actionSearch = 'search'; <-- behövs kanske inte
	public static $actionStart = 'start';

	public static function getAction(){
		if (isset($_GET[self::$action])){
			return $_GET[self::$action];
		}
		//if no action is set, startaction is returned
		return self::$actionStart;
	}
}