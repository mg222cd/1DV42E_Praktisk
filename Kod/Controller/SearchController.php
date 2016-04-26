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
		$this->geonamesModel = new \Model\GeonamesModel();
	}
	
	public function searchScenarios(){
		//Kontroll att något angivits.
		$this->city = $this->searchView->getCity();
		if ($this->city != null) {
			$this->city = $this->geonamesModel->sanitizeText($this->city);
			$this->html = $this->searchView->getCityHeader($this->city);
			//lägg till genames-grejer till htlm under rubtiken
			$this->html .= $this->geonamesScenarios();
			return $this->html;
		}
		return $this->searchView->getErrorMessage();
	}

	private function geonamesScenarios(){
		//Kontroll om geonames webservice fungerar.
		if ($this->geonamesModel->testGeonames() == TRUE) {
			$resultsFromGeonames = $this->geonamesModel->getGeonames($this->city);
			// ... Logik för antal träffar
			if ($this->forecastView->numberOfResultsFromGeonames($resultsFromGeonames) == 0) {
				return $this->forecastView->noResultsFoundErrorMessage();
			}
			elseif ($this->forecastView->numberOfResultsFromGeonames($resultsFromGeonames) == 1) {
				return 'En träff...     ' . $resultsFromGeonames;
				//TODO: visa prognos direkt (& lägg in vald ort i db).
				//TODO: Validate input

			}
			// ... visa i lista ... 
			// TODO: Begränsning och en till elseif-sats om det är mer än t.ex 2000 träffar.
			// ... YR och SMHI
			return 'Många träffar...     ' . $resultsFromGeonames;
		}
		// Geonames är nere...
		//...skriv ut medd om detta
		//...gör sökning
		return $this->forecastView->geonamesWebserviceErrorMessage();
	}




}