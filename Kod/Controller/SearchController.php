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
	private $geonamesRepo;
	private $geonamesView;
	private $numberOfHits;
	private $numberOfHitsHeader;
	private $hitList;

	public function __construct(){
		$this->searchView = new \View\SearchView();
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
			$geonameId = $this->geonamesView->getGeonameId();
			$geonameIdSanitized = $this->geonamesModel->sanitizeText($geonameId);
			$validGeonameId = $this->geonamesModel->getCityByGeonameId($geonameIdSanitized);
			if ($validGeonameId === false) {
				header('Location: ./');
			}
			$geonameIsInDB = $this->geonamesRepo->getGeonamesObjectByGeonameId($geonameId);
			if ($geonameIsInDB === false) {
				$add = $this->geonamesRepo->addCityFromObj($validGeonameId);
			}
			$coordinates = array ('lat' => '123', 'lng' => '456');
			$lat = $this->geonamesModel->parseCoordinate($validGeonameId->getLat());
			$lng = $this->geonamesModel->parseCoordinate($validGeonameId->getLng());
			$_SESSION['lat'] = $lat;
			$_SESSION['lng'] = $lng;
			header('Location: ?forecast='.$validGeonameId->getName().'~'.$validGeonameId->getGeonameId());
		}
		//Kontroll om geonames webservice fungerar.
		if ($this->geonamesModel->testGeonames() == TRUE) {
			$resultsFromGeonames = $this->geonamesModel->getGeonames($this->city);
			$this->numberOfHits = $this->geonamesView->numberOfResultsFromGeonames($resultsFromGeonames);
			$this->numberOfHitsHeader = $this->geonamesView->getNumberOfHitsHeader($this->numberOfHits);
			if ($this->numberOfHits == 0) {
				return $this->geonamesView->noResultsFoundErrorMessage();
			}
			elseif ($this->numberOfHits == 1) {
				$cityExistInDB = $this->geonamesRepo->cityIsAlreadyInDatabase($resultsFromGeonames);
				if ($cityExistInDB == FALSE) {
					$add = $this->geonamesRepo->addCity($resultsFromGeonames);
				}
				$_SESSION['lat'] = $resultsFromGeonames["geonames"][0]['lat'];
				$_SESSION['lng'] = $resultsFromGeonames["geonames"][0]['lng'];
				header('Location: ?forecast='.$resultsFromGeonames["geonames"][0]['name'].'~'.$resultsFromGeonames["geonames"][0]['geonameId']);
			}
			elseif ($this->numberOfHits >= 2 && $this->numberOfHits <= 10) {
				$geonamesObject = $this->geonamesModel->getGeonamesObject($resultsFromGeonames);
				$this->hitList = $this->geonamesView->hitList($geonamesObject);
				return $this->numberOfHitsHeader . $this->hitList;
			}
			elseif ($this->numberOfHits >= 11 && $this->numberOfHits <= 100) {
				$geonamesObject = $this->geonamesModel->getGeonamesObject($resultsFromGeonames);
				$refinedSearchField = $this->geonamesView->refinedSearchField();
				$this->hitList = $this->geonamesView->hitList($geonamesObject);
				return $this->numberOfHitsHeader . $refinedSearchField . $this->hitList;
			}
			elseif ($this->numberOfHits >= 101) {
				//För många träffar, bara förfining.
				return 'Många träffar... Över 100...';
			}
		}
		// Geonames är nere... 
		return $this->geonamesView->geonamesWebserviceErrorMessage() . $this->geonamesView->hitList($this->geonamesRepo->getGeonames($this->city));
	}




}