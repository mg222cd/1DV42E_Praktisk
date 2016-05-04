<?php
namespace Controller;

require_once("./View/NavigationView.php");
require_once("./View/StartView.php");
require_once("./Controller/SearchController.php");
require_once("./Controller/ForecastController.php");

class MainController{
	private $searchController;
	private $startView;
	private $forecastController;

	public function __construct(){
		$this->searchController = new \Controller\SearchController();
		$this->startView = new \View\StartView();
		$this->forecastController = new \Controller\ForecastController();
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
				return $this->startView->startForm();
				break;
		}
	}
}