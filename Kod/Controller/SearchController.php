<?php
namespace Controller;

require_once("./View/SearchView.php");

class SearchController{
	private $searchView;

	public function __construct(){
		$this->searchView = new \View\SearchView();
	}
	
	public function searchScenarios(){
		//TODO: if -- search is made... else show search form
		return $this->searchView->searchForm();
	}
}