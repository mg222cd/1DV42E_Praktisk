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
		//Om användaren tryckt på något i listan url ?search=stad~geonameId
		if ($this->geonamesView->cityFromListIsChoosen() === true) { //Kolla vad som finns i Get på samma vis som i ForecastVyn
			//Hämta geonames Id och stad
			$geonameId = $this->geonamesView->getGeonameId();
			//Sanera båda
			$geonameIdSanitized = $this->geonamesModel->sanitizeText($geonameId);
			//Kolla om id't finns hos geonames webservice
			$validGeonameId = $this->geonamesModel->getCityByGeonameId($geonameIdSanitized);
			//Om nej- det är manipulerat - redirect till startsida
			if ($validGeonameId === false) {
				header('Location: ./');
			}
			//Om ja- kolla om det finns i db
			$geonameIsInDB = $this->geonamesRepo->getGeonamesObjectByGeonameId($geonameId);
			if ($geonameIsInDB === false) {
				$add = $this->geonamesRepo->addCityFromObj($validGeonameId);
			}
			//om ja- redirect till forecast-actionet
			header('Location: ?forecast='.$validGeonameId->getName().'~'.$validGeonameId->getGeonameId());
		}
		//Kontroll om geonames webservice fungerar.
		if ($this->geonamesModel->testGeonames() == TRUE) {
			$resultsFromGeonames = $this->geonamesModel->getGeonames($this->city);
			// ... Logik för antal träffar
			if ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) == 0) {
				return $this->geonamesView->noResultsFoundErrorMessage();
			}
			elseif ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) == 1) {
				$cityExistInDB = $this->geonamesRepo->cityIsAlreadyInDatabase($resultsFromGeonames);
				//Om stad ej finns i DB redan så läggs den till där nu
				if ($cityExistInDB == FALSE) {
					$add = $this->geonamesRepo->addCity($resultsFromGeonames);
				}
				$_SESSION['lat'] = $resultsFromGeonames["geonames"][0]['lat'];
				$_SESSION['lng'] = $resultsFromGeonames["geonames"][0]['lng'];
				header('Location: ?forecast='.$resultsFromGeonames["geonames"][0]['name'].'~'.$resultsFromGeonames["geonames"][0]['geonameId']);
			}
			elseif ($this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) >= 2 
				&& $this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames) <= 10) {
				//TODO... Visa kort lista med träffar
				$geonamesObject = $this->geonamesModel->getGeonamesObject($resultsFromGeonames);
				return $this->geonamesView->hitList($geonamesObject);
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