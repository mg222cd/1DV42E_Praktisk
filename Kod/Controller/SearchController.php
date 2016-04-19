<?php
namespace Controller;

require_once("./View/SearchView.php");

class SearchController{
	private $searchView;

	public function __construct(){
		$this->searchView = new \View\SearchView();
	}
	
	public function searchScenarios(){
		//Kontroll att något angivits.
		if ($this->searchView->getCity() != null) {
			return $this->searchView->getCityHeader();
			//ändra till att visa en rubrik där angiven stad finns med.

		}
		return $this->searchView->getErrorMessage();

		//Fixa rubrik. Sökresultat för....
		//djungeln med webservice och träffar. se testfall...
	}
}