<?php
namespace Controller;

require_once('./View/ForecastView.php');

class ForecastController{
	private $forecastView;
	private $geonamesRepo;
	private $choosenCity;
	private $yrWebservice;
	private $smhiWebservice;

	public function __construct(){
		$this->forecastView = new \View\ForecastView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
	}
	
	public function forecastScenarios(){
		//Hämta hela geonames-objektet ur databasen
		$this->choosenCity = $this->geonamesRepo->getGeonamesObjectByGeonameId($this->forecastView->getGeonameId());
		//Testa om YR och SMHI's webservices fungerar, om inte, skriv ut felmedd om begränsade resultat
		//Oavsett om meddelande om felmedd om begränsade resultat eller ej, hämta och skriv ut prognos från YR och SMHI
		//Lägg till prognoser i DB
		//cachningstrategi
		return 
			$this->forecastView->getForecastHeader($this->choosenCity) .
			//status text webservice 
			$this->forecastView->getForecast() . 
			$this->forecastView->getMap();
	}
}