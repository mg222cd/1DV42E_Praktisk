<?php
namespace Controller;

require_once('./View/ForecastView.php');

class ForecastController{
	private $forecastView;
	private $geonamesRepo;
	private $choosenCity;

	public function __construct(){
		$this->forecastView = new \View\ForecastView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
	}
	
	public function forecastScenarios(){
		//Få ut en korrekt rubrik:
		//Hämta hela geonames-objektet ur databasen
		$this->choosenCity = $this->geonamesRepo->getGeonamesObjectByGeonameId($this->forecastView->getGeonameId());
		var_dump($this->choosenCity);
		//Testa om YR och SMHI's webservices fungerar, om inte, skriv ut felmedd om begränsade resultat
		//Oavsett om meddelande om felmedd om begränsade resultat eller ej, hämta och skriv ut prognos från YR och SMHI
		//Lägg till prognoser i DB
		//cachningstrategi
		return $this->forecastView->getForecastHeader("Test") . $this->forecastView->getForecast() . $this->forecastView->getMap();
	}
}