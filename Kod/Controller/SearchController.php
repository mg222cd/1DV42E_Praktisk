<?php
namespace Controller;

require_once("./View/SearchView.php");
require_once("./Model/GeonamesModel.php");

class SearchController{
	private $searchView;
	private $city;
	private $html;
	private $genamesResults;
	private $webserviceStatusGeonames;
	private $geonamesModel;

	public function __construct(){
		$this->searchView = new \View\SearchView();
	}
	
	public function searchScenarios(){
		//Kontroll att något angivits.
		$this->city = $this->searchView->getCity();
		if ($this->city != null) {
			$this->html = $this->searchView->getCityHeader();
			//lägg till genames-grejer till htlm under rubtiken
			$this->html .= $this->geonamesScenarios();
			return $this->html;
		}
		return $this->searchView->getErrorMessage();
	}

	public function geonamesScenarios(){
		return "teststräng från geonames Scenarios ....     " . $this->city;
	}




}