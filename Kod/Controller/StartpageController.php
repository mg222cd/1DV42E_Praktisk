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
	private $GeonamesView;

	public function __construct(){
		$this->startView = new \View\StartView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrRepo = new \Model\YrRepository();
		$this->GeonamesView = new \View\GeonamesView();
	}

	public function startpage(){
		$latestForecasts = $this->yrRepo->latestForecasts();
		$latestGeonames = $this->geonamesRepo->getGeonamesByPk($latestForecasts);
		$latestList = $this->GeonamesView->hitList($latestGeonames);
		return $this->startView->startForm() . $latestList;
	}




}