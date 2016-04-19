<?php
namespace Controller;

require_once("./View/SearchView.php");

class ForecastController{
	private $searchView;

	public function __construct(){
		$this->searchView = new \View\SearchView();
	}
	
	public function forecastScenarios(){
		return $this->searchView->getCityHeader();
		// Fixa djungeln med webservice och träffar. se testfall...
	}
}