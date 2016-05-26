<?php
namespace Controller;

require_once("./View/NavigationView.php");
require_once("./View/StartView.php");
require_once("./Controller/SearchController.php");
require_once("./Controller/ForecastController.php");
require_once("./Controller/StartpageController.php");

class MainController{
	private $searchController;
	private $startView;
	private $forecastController;
	private $startpageController;


	public function __construct(){
		$this->searchController = new \Controller\SearchController();
		$this->startView = new \View\StartView();
		$this->forecastController = new \Controller\ForecastController();
		$this->startpageController = new \Controller\StartpageController();
	}
	
	public function controlNavigation(){
		switch (\View\NavigationView::getAction()) {
			case 'search':
				return $this->searchController->searchScenarios();
				break;
			case 'forecast':
				return $this->forecastController->forecastScenarios();
				break;
			default:
				return $this->startpageController->startpage();
				break;
		}
	}
}