<?php
namespace Controller;

require_once('./View/SearchView.php');
require_once('./Model/GeonamesModel.php');
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
	private $refinedSearchField;
	private $resultsFromGeonames;

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
			$this->resultsFromGeonames = $this->geonamesModel->getGeonames($this->city);
			//lägg till genames-grejer till htlm under rubtiken
			$this->html .= $this->geonamesScenarios();
			return $this->html;
		}
		//Om förfinad sökning gjorts.
		$this->refinedSearch = $this->searchView->getRefinedSearch();
		if ($this->refinedSearch === TRUE) {
		 	//hämta fälten och sanera dem.
		 	$postedCity = $this->geonamesModel->sanitizeText($this->searchView->getPostedCity()); 
		 	$postedAdminName = $this->geonamesModel->sanitizeText($this->searchView->getPostedAdminName()); 
		 	$postedCountry = $this->geonamesModel->sanitizeText($this->searchView->getPostedCountry()); 
		 	$this->html = $this->searchView->getRefinedHeader($postedCity, $postedAdminName, $postedCountry);
		 	$this->resultsFromGeonames = $this->geonamesModel->getGeonamesRefined($postedCity, $postedAdminName, $postedCountry);
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
			//om geonames är nere ska $validGeonameId inte bli false
			if ($this->geonamesModel->testGeonames() == false) {
				$validGeonameId = $this->geonamesRepo->getGeonamesObjectByGeonameId($geonameIdSanitized);
			}
			if ($validGeonameId === false) {
				header('Location: ./404.html');
			}
			$geonameIsInDB = $this->geonamesRepo->getGeonamesObjectByGeonameId($geonameId);
			if ($geonameIsInDB === false) {
				$add = $this->geonamesRepo->addCityFromObj($validGeonameId);
			}
			$lat = $this->geonamesModel->parseCoordinate($validGeonameId->getLat());
			$lng = $this->geonamesModel->parseCoordinate($validGeonameId->getLng());
			$_SESSION['lat'] = $lat;
			$_SESSION['lng'] = $lng;
			header('Location: ?forecast='.$validGeonameId->getName().'~'.$validGeonameId->getGeonameId());
		}
		//Kontroll om geonames webservice fungerar.
		if ($this->geonamesModel->testGeonames() == TRUE) {
			$this->numberOfHits = $this->geonamesView->numberOfResultsFromGeonames($this->resultsFromGeonames);
			$this->numberOfHitsHeader = $this->geonamesView->getNumberOfHitsHeader($this->numberOfHits);
			if ($this->numberOfHits == 0) {
				return $this->geonamesView->noResultsFoundErrorMessage();
			}
			elseif ($this->numberOfHits == 1) {
				$cityExistInDB = $this->geonamesRepo->cityIsAlreadyInDatabase($this->resultsFromGeonames);
				if ($cityExistInDB == FALSE) {
					$add = $this->geonamesRepo->addCity($this->resultsFromGeonames);
				}
				$_SESSION['lat'] = $this->resultsFromGeonames["geonames"][0]['lat'];
				$_SESSION['lng'] = $this->resultsFromGeonames["geonames"][0]['lng'];
				header('Location: ?forecast='.$this->resultsFromGeonames["geonames"][0]['name'].'~'.$this->resultsFromGeonames["geonames"][0]['geonameId']);
			}
			elseif ($this->numberOfHits >= 2 && $this->numberOfHits <= 10) {
				$geonamesObject = $this->geonamesModel->getGeonamesObject($this->resultsFromGeonames);
				$this->hitList = $this->geonamesView->hitList($geonamesObject);
				return $this->numberOfHitsHeader . $this->hitList;
			}
			elseif ($this->numberOfHits >= 11 && $this->numberOfHits <= 100) {
				$geonamesObject = $this->geonamesModel->getGeonamesObject($this->resultsFromGeonames);
				$refinedSearchField = $this->geonamesView->refinedSearchField();
				$this->hitList = $this->geonamesView->hitList($geonamesObject);
				return $this->numberOfHitsHeader . $refinedSearchField . $this->hitList;
			}
			elseif ($this->numberOfHits >= 101) {
				$geonamesObject = $this->geonamesModel->getGeonamesObject($this->resultsFromGeonames);
				$tooManyResultsMessage = $this->geonamesView->tooManyResults($this->numberOfHits);
				$refinedSearchField = $this->geonamesView->refinedSearchField();
				$this->hitList = $this->geonamesView->hitList($geonamesObject);
				return $tooManyResultsMessage . $refinedSearchField . $this->hitList;
			}
		}
		// Geonames är nere... 
		return $this->geonamesView->geonamesWebserviceErrorMessage() . $this->geonamesView->hitList($this->geonamesRepo->getGeonames($this->city));
	}

}