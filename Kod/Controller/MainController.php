<?php
namespace Controller;

require_once("./View/NavigationView.php");
require_once("./View/StartView.php");
require_once("./Controller/SearchController.php");

class MainController{
	private $searchController;
	private $startView;

	public function __construct(){
		$this->searchController = new \Controller\SearchController();
		$this->startView = new \View\StartView();
	}
	
	public function controlNavigation(){
		switch (\View\NavigationView::getAction()) {
			case 'showForecast':
				return 
				'showForecast';
				break;
			case 'search':
				//return 'search action';
				return $this->searchController->searchScenarios();
				break;
			default:
				//return 'start';
				return $this->startView->startForm();
				break;
		}
	}
}