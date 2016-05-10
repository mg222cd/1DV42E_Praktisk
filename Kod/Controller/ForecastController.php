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
	private $yrWebservice;
	private $smhiWebservice;

	public function __construct(){
		$this->forecastView = new \View\ForecastView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrModel = new \Model\YrModel();
		$this->smhiModel = new \Model\SmhiModel();
	}
	
	public function forecastScenarios(){
		//Hämta hela geonames-objektet ur databasen
		$this->choosenCity = $this->geonamesRepo->getGeonamesObjectByGeonameId($this->forecastView->getGeonameId());
		//Testa om YR och SMHI's webservices fungerar, om inte, skriv ut felmedd om begränsade resultat
		$this->yrWebservice = $this->yrModel->testYrWebservice($this->choosenCity);
		$this->smhiWebservice = $this->smhiModel->testSmhiWebservice($this->choosenCity);
		//Oavsett om meddelande om felmedd om begränsade resultat eller ej, hämta och skriv ut prognos från YR och SMHI
		//Lägg till prognoser i DB
		//cachningstrategi
		return 
			$this->forecastView->getForecastHeader($this->choosenCity) .
			$this->forecastView->getWebserviceStatus($this->yrWebservice, $this->smhiWebservice) .
			$this->forecastView->getForecast() . 
			$this->forecastView->getMap();
	}
}