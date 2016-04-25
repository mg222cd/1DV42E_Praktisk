<?php
namespace Controller;

require_once('./View/SearchView.php');
require_once('./Model/GeonamesModel.php');
require_once('./View/ForecastView.php');

class SearchController{
	private $searchView;
	private $city;
	private $html;
	private $geonamesModel;
	private $forecastView;

	public function __construct(){
		$this->searchView = new \View\SearchView();
		$this->forecastView = new \View\ForecastView();
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
		//KOLLA om geonames webservice fungerar.
		if ($this->geonamesModel->testGeonames() == TRUE) {
			$resultsFromGeonames = $this->geonamesModel->getGeonames($this->city);
			// ... Kolla om staden hittades hos geonames
			if ($forecastView->numberOfResultsFromGeonames($resultsFromGeonames) == 0) {
				return $this->forecastView->noResultsFoundErrorMessage();
			}
			elseif ($forecastView->numberOfResultsFromGeonames($resultsFromGeonames) == 1) {
				//visa prognos direkt
			}
			// ... visa i lista ... (OBS OM STADEN INNEHÅLLER MELLANSLAG)
			// ... YR och SMHI
			return 'Många träffar...' . $resultsFromGeonames;
		}
		// Geonames är nere...
		//...skriv ut medd om detta
		//...gör sökning
		return $this->forecastView->geonamesWebserviceErrorMessage();
	}




}