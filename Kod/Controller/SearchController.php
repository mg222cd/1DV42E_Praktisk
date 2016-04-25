<?php
namespace Controller;

require_once("./View/SearchView.php");
require_once("./Model/GeonamesModel.php");

class SearchController{
	private $searchView;
	private $city;
	private $html;
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

	private function geonamesScenarios(){
		$this->geonamesModel = new \Model\GeonamesModel($this->city);
		//KOLLA om geonames fungerar, isåfall, kör på o sök mot YR och SMHI. om inte, skriv meddelande o sök från databas
		if ($this->geonamesModel->testGeonames() == TRUE) {
			//Genames webservice funkar, kör på med...
			// ... Staden hos Geonames (OBS OM STADEN INNEHÅLLER MELLANSLAG)
			// ... YR och SMHI
			return null;
		}
		//Geonames är nere...
		//...skriv ut medd om detta
		//...gör sökning
		return null;
	}




}