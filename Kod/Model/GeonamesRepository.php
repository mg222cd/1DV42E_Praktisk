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
	private $lng ='lang';
	
	public function __construct(){
		$this->dbTable = 'geonames';
	}

	public function addCity($cityArray){
		//var_dump($cityArray);die();
		//var_dump($cityArray["geonames"][0]['geonameId']);die();

		
		$geonames = new \model\Geonames(
			$cityArray["geonames"][0]['geonameId'], 
			$cityArray["geonames"][0]['name'], 
			$cityArray["geonames"][0]['adminName1'], 
			$cityArray["geonames"][0]['adminName1'], 
			$cityArray["geonames"][0]['countryName'],
			$cityArray["geonames"][0]['lat'],
			$cityArray["geonames"][0]['lng']);

		var_dump($geonames);die();
	}

}