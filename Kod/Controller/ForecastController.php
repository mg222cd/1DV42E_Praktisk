<?php
namespace Controller;

require_once('./View/ForecastView.php');
require_once('./Model/GeonamesRepository.php');
require_once('./Model/YrModel.php');
require_once('./Model/SmhiModel.php');
require_once('./Model/YrRepository.php');

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

	public function __construct(){
		$this->forecastView = new \View\ForecastView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrModel = new \Model\YrModel();
		$this->smhiModel = new \Model\SmhiModel();
		$this->yrRepo = new \Model\YrRepository();
	}
	
	public function forecastScenarios(){
		//Grundläggande parametrar
		$this->choosenCity = $this->geonamesRepo->getGeonamesObjectByGeonameId($this->forecastView->getGeonameId());
		$this->yrWebserviceStatus = $this->yrModel->testYrWebservice($this->choosenCity);
		$this->smhiWebserviceStatus = $this->smhiModel->testSmhiWebservice($this->choosenCity);
		//Hämta prognoser.
		// 1a. Kolla om prognos från Yr redan finns i DB
		$validYrForecast = $this->yrRepo->isThereValidForecastInDatabase($this->choosenCity);
		if ($validYrForecast == false) {
			//2a. Prognos finns inte, hämta från YR's webservice och spara i DB
			$this->forecastYr = $this->yrModel->getYrForecast($this->choosenCity);
			$addYrToDB = $this->yrRepo->addYrForecast($this->forecastYr, $this->choosenCity->getGeonamesPk());
		}
		//3a. Hämta prognos ut databas Yr

		// 1b. Kolla om prognos från Smhi redan finns i DB
			//2a. Prognos finns inte, hämta från SMHI's webservice och spara i DB
			$this->forecastSmhi = $this->smhiModel->getSmhiForecast($this->choosenCity);
		//3a. Hämta prognos ut databas Smhi

		// 4. Skicka båda prognoserna till funktion i Vyn, som snyggar till dem.
		return 
			$this->forecastView->getForecastHeader($this->choosenCity) .
			$this->forecastView->getWebserviceStatus($this->yrWebserviceStatus, $this->smhiWebserviceStatus) .
			$this->forecastView->getForecast() . 
			$this->forecastView->getMap();
	}
}