<?php
namespace Controller;

require_once('./View/ForecastView.php');

class ForecastController{
	private $forecastView;

	public function __construct(){
		$this->forecastView = new \View\ForecastView();
	}
	
	public function forecastScenarios(){
		//var_dump($_SESSION);die();
		return $this->forecastView->getForecast() . $this->forecastView->getMap();
	}
}