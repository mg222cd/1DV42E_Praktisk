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
		//prognosens datumparametrar
		$timeOfStorage = $this->helper->getCurrentTime();;
		$lastupdate = $this->helper->getLastUpdate($yrObject);
		$nextUpdate = $this->helper->getNextUpdate($yrObject); 
		//krånglar igenom alla nästlade objekt och arrayer så att det slutl blir ett Yr-objekt
		$forecast = (array) $yrObject->forecast->tabular;
		$forecasts = (array) $forecast['time'];
		foreach ($forecasts as $forecast) {
			$eachForecast = (array) $forecast;
			$this->yrList[] = new \Model\Yr(
				null, //<-- YrPk inte satt ännu
				$geonamesPk,
				$timeOfStorage,
				$lastupdate,
				$nextUpdate,
				$timeperiod = (int) $eachForecast["@attributes"]["period"],
				$symbolId = (string) $eachForecast["symbol"]["var"],
				$temperature = (int) $eachForecast["temperature"]["value"],
				$windDirectionDeg = (float) $eachForecast["windDirection"]["deg"],
				$windSpeed = (string) $eachForecast["windSpeed"]["mps"]
				);
		}

		foreach ($this->yrList as $value) {
			try{
				$db = $this->connection();
				
				$sql = "INSERT INTO $this->dbTable ("
					.$this->geonamesPk.","
					.$this->timeOfStorage.","
					.$this->lastUpdate.","
					.$this->nextUpdate.","
					.$this->timeperiod.","
					.$this->symbolId.","
					.$this->temperature.","
					.$this->windDirectionDeg.","
					.$this->windSpeed.")
	               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$params = array (
					$value->getGeonamesPk(),
					$value->getTimeOfStorage(),
					$value->getLastUpdate(),
					$value->getNextUpdate(),
					$value->getTimeperiod(),
					$value->getSymbolId(),
					$value->getTemperature(),
					$value->getWindDirectionDeg(),
					$value->getWindSpeed());
				$query = $db->prepare($sql);
				$query->execute($params);
		}
		catch(\PDOException $e){
			throw new \Exception($e->getMessage());
		}
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