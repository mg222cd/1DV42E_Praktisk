<?php
namespace Controller;

require_once("./View/SearchView.php");

class ForecastController{
	private $searchView;

	public function __construct(){
		$this->searchView = new \View\SearchView();
	}
	
	public function forecastScenarios($searchHeader){
		return $searchHeader;
		// Fixa djungeln med webservice och träffar. se testfall...
	}
}