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
				'<div class="col-xs-12 col-sm-10">
		        	<p>
		        		<p> gör en controller som hanterar scenarios för sökningar. </p>
						<p> 1. Kontrollera att något ens har angivits, annars felmedelande. </p>
						<p> 2. Fixa rubrik i stil med "Sökresultat för ____". </p>
						<p> 3. Om orten inte hittades, visa meddelande om detta. </p>
						<p> 4. Om flera orter hittades, visa lista. </p>
						<p> 5. Om bara 1 st ort hittades, pang rätt på prognos. </p>
		        	</p>
		    	</div>';
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