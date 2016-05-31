<?php
namespace Controller;

require_once('./View/StartView.php');
require_once('./Model/GeonamesRepository.php');
require_once('./Model/YrRepository.php');
require_once('./View/GeonamesView.php');

class StartpageController{
	private $startView;
	private $geonamesRepo;
	private $yrRepo;
	private $geonamesView;

	public function __construct(){
		$this->startView = new \View\StartView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrRepo = new \Model\YrRepository();
		$this->geonamesView = new \View\GeonamesView();
	}

	public function startpage(){
		$latestForecasts = $this->yrRepo->latestForecasts();
		$latestGeonames = $this->geonamesRepo->getGeonamesByPk($latestForecasts);
		$latestList = $this->geonamesView->hitList($latestGeonames);
		return $this->startView->startForm() . $latestList;
	}

}