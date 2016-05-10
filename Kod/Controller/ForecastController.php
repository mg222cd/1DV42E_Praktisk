<?php
namespace Controller;

require_once('./View/ForecastView.php');
require_once('./Model/GeonamesRepository.php');
require_once('./Model/YrModel.php');
require_once('./Model/SmhiModel.php');

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

	public function __construct(){
		$this->forecastView = new \View\ForecastView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrModel = new \Model\YrModel();
		$this->smhiModel = new \Model\SmhiModel();
	}
	
	public function forecastScenarios(){
		//Grundläggande parametrar
		$this->choosenCity = $this->geonamesRepo->getGeonamesObjectByGeonameId($this->forecastView->getGeonameId());
		$this->yrWebserviceStatus = $this->yrModel->testYrWebservice($this->choosenCity);
		$this->smhiWebserviceStatus = $this->smhiModel->testSmhiWebservice($this->choosenCity);
		//Hämta prognoser.
		// 1a. Kolla om prognos från Yr redan finns i DB, isåfall, hämta den.
		// 2a. Om prognos ej finns i DB, hämta från YrWebservice
		// 3a. Spara prognosen i databasen

		// 1b. Kolla om prognos från Yr redan finns i DB, isåfall, hämta den.
		// 2b. Om prognos ej finns i DB, hämta från YrWebservice
		// 3b. Spara prognosen i databasen
		
		// 4. Skicka båda prognoserna till funktion i Vyn, som snyggar till dem.
		return 
			$this->forecastView->getForecastHeader($this->choosenCity) .
			$this->forecastView->getWebserviceStatus($this->yrWebserviceStatus, $this->smhiWebserviceStatus) .
			$this->forecastView->getForecast() . 
			$this->forecastView->getMap();
	}
}