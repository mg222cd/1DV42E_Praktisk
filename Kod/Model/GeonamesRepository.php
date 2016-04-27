<?php
namespace Model;

require_once("./Model/DatabaseConnection.php");
require_once("./Model/Geonames.php");

class GeonamesRepository extends DatabaseConnection{
	//private $geonamesList = array();
	private $geonamesPk = 'geonamesPk';
	private $geonameId = 'geonameId';
	private $name = 'name';
	private $adminName1 = 'adminName1';
	private $adminName2 = 'adminName2';
	private $countryName = 'countryName';
	private $lat ='lat';
	private $lang ='lang';
	
	public function __construct(){
		$this->dbTable = 'geonames';
	}

	/*
	public function addCity($geonamesPk, $geonameId, $name, $adminName1, $adminName2, $countryName, $lat, $lang){
		return NULL;
	}*/

	public function addCity($cityArray){
		var_dump($cityArray);die();
	}

}