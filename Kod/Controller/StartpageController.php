<?php
namespace Controller;

require_once('./View/StartView.php');
require_once('./Model/GeonamesRepository.php');
require_once('./Model/YrRepository.php');

class StartpageController{
	private $startView;
	private $geonamesRepo;
	private $yrRepo;

	public function __construct(){
		$this->startView = new \View\StartView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
		$this->yrRepo = new \Model\YrRepository();
	}

	public function startpage(){
		$latestForecasts = $this->yrRepo->latestForecasts();
		var_dump($latestForecasts);
		return $this->startView->startForm();
	}




}