<?php
namespace Model;

require_once('./Model/DatabaseConnection.php');
require_once('./Model/Yr.php');
require_once('./Model/RepositoryHelpclass.php');

class YrRepository extends DatabaseConnection{
	private $yrObject;
	private $yrList = array();
	private $yrPk = 'yrPk';
	private $geonamesPk = 'geonamesPk';
	private $timeOfStorage = 'timeOfStorage';
	private $lastUpdate = 'lastUpdate';
	private $nextUpdate = 'nextUpdate';
	private $timeperiod = 'timeperiod';
	private $symbolId = 'symbolId';
	private $temperature = 'temperature';
	private $windDirectionDeg = 'windDirectionDeg';
	private $windSpeed = 'windSpeed';
	private $helper;
	
	public function __construct(){
		$this->dbTable = 'yr';
		$this->helper = new \Model\RepositoryHelpclass();
	}
	
	public function addYrForecast($yrObject, $geonamesPk){
		//gör om obj till array så det blir mer lättarbetat
		$yrArray = 	(array) $yrObject; //<-- kanske ej behövs
		//tiden just nu
		$timeOfStorage = date("Y-m-d H:i:s");

		/*
		echo '<pre>';
		print_r($yrObject);
		echo '</pre>';
		exit;
		die();
		*/

		//$lastUpdate = (string) $yrObject->meta->lastupdate; 
		//var_dump($lastUpdate);die();
		$lastupdate = $this->helper->getLastUpdate($yrObject);
		$nextUpdate; 
		$timeperiod;

		$yr = new \model\Yr(
			null, // <- yrPk 
			$geonamesPk, //klar
			$timeOfStorage, 
			$lastUpdate, 
			$nextUpdate, 
			$timeperiod, 
			$symbolId, 
			$temperature, 
			$windDirectionDeg, 
			$windSpeed);

		try{
			$db = $this->connection();
			
			$sql = "INSERT IGNORE INTO $this->dbTable ("
				.$this->geonameId.","
				.$this->name.","
				.$this->adminName1.","
				.$this->adminName2.","
				.$this->countryName.","
				.$this->fcodeName.","
				.$this->lat.","
				.$this->lng.")
               VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
			$params = array (
				$geonames->getGeonameId(), 
				$geonames->getName(),
				$geonames->getAdminName1(),
				$geonames->getAdminName2(),
				$geonames->getCountryName(),
				$geonames->getFcodeName(),
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

	/*
	public function getGeonames($cityname){
		try {
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.geonamesPk, $this->dbTable.geonameId, $this->dbTable.name, $this->dbTable.adminName1, 
							$this->dbTable.adminName2, $this->dbTable.countryName, $this->dbTable.fcodeName, $this->dbTable.lat, $this->dbTable.lng 
					FROM $this->dbTable
					WHERE name = :name
					";

			$params = array(':name' => $cityname);
			$query = $db->prepare($sql);
			$query->execute($params);

			foreach ($query->fetchAll() as $geonames) {
				$geonamesPk = $geonames['geonamesPk'];
				$geonameId = $geonames['geonameId'];
				$name = $geonames['name'];
				$adminName1 = $geonames['adminName1'];
				$adminName2 = $geonames['adminName2'];
				$countryName = $geonames['countryName'];
				$fcodeName = $geonames['fcodeName'];
				$lat = $geonames['lat'];
				$lng = $geonames['lng'];
				$this->geonamesList[] = new \Model\Geonames($geonamesPk, $geonameId, $name, $adminName1, $adminName2, $countryName, $fcodeName, $lat, $lng);
			}
			return $this->geonamesList;
		} catch (Exception $e) {
			throw new \Exception('Fel uppstod i samband med hämtning av städer från databasen.');
		}
	}
	*/

	/*
	public function getGeonamesObjectByGeonameId($geonameId){
		try {
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.geonamesPk, $this->dbTable.geonameId, $this->dbTable.name, $this->dbTable.adminName1, 
							$this->dbTable.adminName2, $this->dbTable.countryName, $this->dbTable.fcodeName, $this->dbTable.lat, $this->dbTable.lng 
					FROM $this->dbTable
					WHERE geonameId = :geonameId
					";

			$params = array(':geonameId' => $geonameId);
			$query = $db->prepare($sql);
			$query->execute($params);

			$geonames = $query->fetchAll();
			//var_dump($geonames[0]['geonamesPk']);die();
			$geonamesPk = $geonames[0]['geonamesPk'];
			$geonameId = $geonames[0]['geonameId'];
			$name = $geonames[0]['name'];
			$adminName1 = $geonames[0]['adminName1'];
			$adminName2 = $geonames[0]['adminName2'];
			$countryName = $geonames[0]['countryName'];
			$fcodeName = $geonames[0]['fcodeName'];
			$lat = $geonames[0]['lat'];
			$lng = $geonames[0]['lng'];
			$this->geonamesObject = new \Model\Geonames(
					$geonamesPk, $geonameId, $name, $adminName1, $adminName2, $countryName, $fcodeName, $lat, $lng
					);

			return $this->geonamesObject;
		} catch (Exception $e) {
			throw new \Exception('Fel uppstod i samband med hämtning av städer från databasen.');
		}
	}
	*/

	/*
	public function cityIsAlreadyInDatabase($cityArray){
		$geonameId = $cityArray["geonames"][0]['geonameId'];
		try {
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.geonamesPk, $this->dbTable.geonameId, $this->dbTable.name, $this->dbTable.adminName1, 
							$this->dbTable.adminName2, $this->dbTable.countryName, $this->dbTable.fcodeName, $this->dbTable.lat, $this->dbTable.lng 
					FROM $this->dbTable
					WHERE geonameId = :geonameId
					";

			$params = array(':geonameId' => $geonameId);
			$query = $db->prepare($sql);
			$query->execute($params);

			$geonames = $query->fetchAll();
			$hits = count($geonames);
			if ($hits == 0) {
				return FALSE;
			}
			else if ($hits >= 1) {
				return TRUE;
			}
			
		} catch (Exception $e) {
			throw new \Exception('Fel uppstod i samband med hämtning av städer från databasen.');
		}
	}
	*/

}