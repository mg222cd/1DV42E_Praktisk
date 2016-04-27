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
	private $lng ='lng';
	
	public function __construct(){
		$this->dbTable = 'geonames';
	}

	public function addCity($cityArray){		
		$geonames = new \model\Geonames(
			$cityArray["geonames"][0]['geonameId'], 
			$cityArray["geonames"][0]['name'], 
			$cityArray["geonames"][0]['adminName1'], 
			$cityArray["geonames"][0]['adminName2'], 
			$cityArray["geonames"][0]['countryName'],
			$cityArray["geonames"][0]['lat'],
			$cityArray["geonames"][0]['lng']);

		try{
			$db = $this->connection();
			
			$sql = "INSERT INTO $this->dbTable ("
				.$this->geonameId.","
				.$this->name.","
				.$this->adminName1.","
				.$this->adminName2.","
				.$this->countryName.","
				.$this->lat.","
				.$this->lng.")
               VALUES (?, ?, ?, ?, ?, ?, ?);";
			$params = array (
				$geonames->getGeonameId(), 
				$geonames->getName(),
				$geonames->getAdminName1(),
				$geonames->getAdminName2(),
				$geonames->getCountryName(),
				$geonames->getLat(),
				$geonames->getLng());
			$query = $db->prepare($sql);
			$query->execute($params);
			return TRUE;
		}
		catch(\PDOException $e){
			throw new \Exception('Ett fel uppstod då orten skulle läggas till i databasen.');
		}

	}

}