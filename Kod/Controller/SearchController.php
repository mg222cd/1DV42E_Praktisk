<?php
namespace Controller;

require_once('./View/SearchView.php');
require_once('./Model/GeonamesModel.php');
//require_once('./View/ForecastView.php');
require_once('./View/GeonamesView.php');
require_once('./Model/GeonamesRepository.php');

class SearchController{
	private $searchView;
	private $city;
	private $html;
	private $geonamesModel;
	//private $forecastView;
	private $geonamesRepo;
	private $geonamesView;

	public function __construct(){
		$this->searchView = new \View\SearchView();
		//$this->forecastView = new \View\ForecastView();
		$this->geonamesModel = new \Model\GeonamesModel();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->geonamesView = new \View\GeonamesView();
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
			if ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) == 0) {
				return $this->geonamesView->noResultsFoundErrorMessage();
			}
			elseif ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) == 1) {
				if ($this->geonamesRepo->addCity($resultsFromGeonames)) {
					$_SESSION['lat'] = $resultsFromGeonames["geonames"][0]['lat'];
					$_SESSION['lng'] = $resultsFromGeonames["geonames"][0]['lng'];
					header('Location: ?forecast=Bruksvallarna');
				}
			}
			elseif ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) >= 2 
				&& $this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) <= 10) {
				//TODO... Visa kort lista med träffar
				return '2-10 träffar...     ' . $resultsFromGeonames;
				//return $this->geonamesView->shortList();
			}
			elseif ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) >= 11
				&& $this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) <= 2000) {
				//TODO... Förfinad filtrering och sen paginerade träffar.
				return '11-2000 träffar...     ' . $resultsFromGeonames;
			}
			elseif ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) >= 2001) {
				//För många träffar, bara förfining.
				return 'Många träffar... Över 2000...';
			}
		}
		// Geonames är nere... 
		return $this->geonamesView->geonamesWebserviceErrorMessage() . $this->geonamesView->hitList($this->geonamesRepo->getGeonames($this->city));
	}




}