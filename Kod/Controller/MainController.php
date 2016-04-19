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
	private $searchHeader;

	public function __construct(){
		$this->searchController = new \Controller\SearchController();
		$this->startView = new \View\StartView();
		$this->forecastController = new \Controller\ForecastController();
	}
	
	public function controlNavigation(){
		switch (\View\NavigationView::getAction()) {
			case 'search':
				$this->searchHeader = $this->searchController->searchScenarios();
				return $this->forecastController->forecastScenarios($this->searchHeader);
				break;
			default:
				return $this->startView->startForm();
				break;
		}
	}
}