<?php
namespace Controller;

require_once('./View/StartView.php');
require_once('./Model/GeonamesRepository.php');

class StartpageController{
	private $startView;
	private $geonamesRepo;

	public function __construct(){
		$this->startView = new \View\StartView();
		$this->geonamesRepo = new \Model\GeonamesRepository();
	}

	public function startpage(){
		return $this->startView->startForm();
	}




}