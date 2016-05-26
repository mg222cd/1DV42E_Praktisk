<?php
namespace Controller;

require_once('./View/ForecastView.php');
require_once('./Model/GeonamesRepository.php');
require_once('./Model/YrModel.php');
require_once('./Model/SmhiModel.php');
require_once('./Model/YrRepository.php');
require_once('./Model/SmhiRepository.php');

class ForecastController{
	private $forecastView;
	private $geonamesRepo;
	private $yrModel;
	private $smhiModel;
	private $choosenCity;
	private $yrWebserviceStatus;
	private $smhiWebserviceStatus;
	private $forecastYr;
	private $forecastSmhi;
	private $yrRepo;
	private $smhiRepo;
	private $yr;
	private $smhi = null;


	public function __construct(){
		$this->forecastView = new \View\ForecastView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrModel = new \Model\YrModel();
		$this->smhiModel = new \Model\SmhiModel();
		$this->yrRepo = new \Model\YrRepository();
		$this->smhiRepo = new \Model\SmhiRepository();
	}
	
	public function forecastScenarios(){
		//Hängslen och livrem att URL är ok och att GeonamesID verkligen finns i DB
		if ($this->forecastView->urlIsOk() == false ) {
			//url är manipulerad och får ej att använda i denna controller
			header('Location: ./');
		}
		//koll om GeonameId verkligen finns i DB
		$stringToSanitize = $this->forecastView->getGeonameId();
		$sanitizedString = $this->yrModel->sanitizeText($stringToSanitize);
		$idIsInDatabase = $this->geonamesRepo->checkExists($sanitizedString);
		if ($idIsInDatabase == false) {
			//GeonameId i URL:en är manipulerad och går ej att använda
			header('Location: ./');
		}
		//Grundläggande parametrar
		$this->choosenCity = $this->geonamesRepo->getGeonamesObjectByGeonameId($this->forecastView->getGeonameId());
		$this->yrWebserviceStatus = $this->yrModel->testYrWebservice($this->choosenCity);
		$this->smhiWebserviceStatus = $this->smhiModel->testSmhiWebservice($this->choosenCity);
		//YR
		//Kolla om prognos från Yr redan finns i DB
		if ($validYrForecast = $this->yrRepo->checkExists($this->choosenCity) == FALSE) {
			//Prognos finns inte, hämta från YR's webservice och spara i DB
			$this->forecastYr = $this->yrModel->getYrForecast($this->choosenCity);
			if ($this->forecastYr != false) {
				$addYrToDB = $this->yrRepo->addYrForecast($this->forecastYr, $this->choosenCity->getGeonamesPk());
			}
		}
		//Prognos finns, kolla om den är aktuell att använda
		$validYrForecast = $this->yrRepo->isThereValidForecastInDatabase($this->choosenCity);
		if ($validYrForecast == FALSE) {
			//Prognosen är gammal, radera den, hämta ny från YR webservice, spara ny prognos.
			$delete = $this->yrRepo->deleteForecasts($this->choosenCity);
			$this->forecastYr = $this->yrModel->getYrForecast($this->choosenCity);
			if ($this->forecastYr != false) {
				$addYrToDB = $this->yrRepo->addYrForecast($this->forecastYr, $this->choosenCity->getGeonamesPk());
			}
		}
		//Hämta aktuell prognos ur DB, som yrObjekt
		$this->yr = $this->yrRepo->getForecast($this->choosenCity);
		
		//SMHI
		//Kolla om prognos från Smhi redan finns i DB
		if ($this->smhiRepo->checkExists($this->choosenCity) == FALSE) {
			//Prognos finns inte, hämta från SMHI's webservice och spara i DB
			$this->forecastSmhi = $this->smhiModel->getSmhiForecast($this->choosenCity);
			if ($this->forecastSmhi != false) {
				$this->smhiRepo->addForecast($this->forecastSmhi, $this->choosenCity->getGeonamesPk());
			}
		}
		//Prognos finns, kolla om den är aktuell att använda.
		$validSmhiForecast = $this->smhiRepo->isThereValidForecastInDatabase($this->choosenCity);
		if ($validSmhiForecast == FALSE) {
			//Prognosen är gammal, radera den, hämta ny från YR webservice, spara ny prognos.
			$delete = $this->smhiRepo->deleteForecasts($this->choosenCity);
			$this->forecastSmhi = $this->smhiModel->getSmhiForecast($this->choosenCity);
			if ($this->forecastSmhi != false) {
				$this->smhiRepo->addForecast($this->forecastSmhi, $this->choosenCity->getGeonamesPk());
			}
		}
		//Hämta aktuell prognos ur DB, som smhiObjekt
		$this->smhi = $this->smhiRepo->getForecast($this->choosenCity);

		//Skicka båda prognoserna till funktion i Vyn, som snyggar till dem. Om någon av prognoserna är tomma - tom lista.
		return 
			$this->forecastView->getForecastHeader($this->choosenCity) .
			$this->forecastView->getWebserviceStatus($this->yrWebserviceStatus, $this->smhiWebserviceStatus) .
			$this->forecastView->getForecast($this->yr, $this->smhi) . 
			$this->forecastView->getMap();
	}
}