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
	private $timeFrom = 'timeFrom';
	private $timeTo = 'timeTo';
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
				$timeFrom = $this->helper->getTimeFrom($eachForecast), 
				$timeTo = $this->helper->getTimeTo($eachForecast), 
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
					.$this->timeFrom.","
					.$this->timeTo.","
					.$this->timeperiod.","
					.$this->symbolId.","
					.$this->temperature.","
					.$this->windDirectionDeg.","
					.$this->windSpeed.")
	               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$params = array (
					$value->getGeonamesPk(),
					$value->getTimeOfStorage(),
					$value->getLastUpdate(),
					$value->getNextUpdate(),
					$value->getTimeFrom(),
					$value->getTimeTo(),
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

	public function checkExists($geonamesObject){
		$geonamesPk = $geonamesObject->getGeonamesPk();

		try {
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.yrPk, $this->dbTable.geonamesPk, $this->dbTable.timeOfStorage, $this->dbTable.lastUpdate, 
							$this->dbTable.nextUpdate, $this->dbTable.timeFrom, $this->dbTable.timeTo, $this->dbTable.timeperiod, 
							$this->dbTable.symbolId, $this->dbTable.temperature, $this->dbTable.windDirectionDeg, $this->dbTable.windSpeed
					FROM $this->dbTable
					WHERE geonamesPk = :geonamesPk
					";

			$params = array(':geonamesPk' => $geonamesPk);
			$query = $db->prepare($sql);
			$query->execute($params);
			if ($query->rowCount() > 0) {
				return TRUE;
			}
			return FALSE;
		} catch (Exception $e) {
			throw new \Exception('Fel uppstod i samband med hämtning av städer från databasen.');
		}
	}

	public function isThereValidForecastInDatabase($geonamesObject){
		$geonamesPk = $geonamesObject->getGeonamesPk();

		try {
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.yrPk, $this->dbTable.geonamesPk, $this->dbTable.timeOfStorage, $this->dbTable.lastUpdate, 
							$this->dbTable.nextUpdate, $this->dbTable.timeFrom, $this->dbTable.timeTo, $this->dbTable.timeperiod, 
							$this->dbTable.symbolId, $this->dbTable.temperature, $this->dbTable.windDirectionDeg, $this->dbTable.windSpeed
					FROM $this->dbTable
					WHERE geonamesPk = :geonamesPk
					";

			$params = array(':geonamesPk' => $geonamesPk);
			$query = $db->prepare($sql);
			$query->execute($params);
			$now = new \DateTime();
			foreach ($query->fetchAll() as $yr) {
				$expirationDate = $yr['nextUpdate'];
				$validForecast = $expirationDate > $now->format('Y-m-d H:i:s');
				if ($validForecast == TRUE) {
					return TRUE;
				}
			}
			return FALSE;
		} catch (Exception $e) {
			throw new \Exception('Fel uppstod i samband med hämtning av städer från databasen.');
		}
	}

	public function deleteForecasts($geonamesObject){
		$geonamesPk = $geonamesObject->getGeonamesPk();
		try{
			$db = $this->connection();
			$sql = "DELETE FROM $this->dbTable WHERE geonamesPk=?";
			$params = array ($geonamesPk);
			$query = $db->prepare($sql);
			$query->execute($params);
			//return $query->rowCount() > 0;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då prognoser skulle tas bort ur databasen.');
		}	
	}

	public function getForecast($geonamesObject){
		$geonamesPk = $geonamesObject->getGeonamesPk();
		try{
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.yrPk, $this->dbTable.geonamesPk, $this->dbTable.timeOfStorage, $this->dbTable.lastUpdate, 
							$this->dbTable.nextUpdate, $this->dbTable.timeFrom, $this->dbTable.timeTo, $this->dbTable.timeperiod, 
							$this->dbTable.symbolId, $this->dbTable.temperature, $this->dbTable.windDirectionDeg, $this->dbTable.windSpeed
					FROM $this->dbTable
					WHERE geonamesPk = :geonamesPk
					";
			$params = array(':geonamesPk' => $geonamesPk);
			$query = $db->prepare($sql);
			$query->execute($params);
			foreach ($query->fetchAll() as $yr) {
				$yrPk = $yr['yrPk'];
				$geonamesPk = $yr['geonamesPk'];
				$timeOfStorage = $yr['timeOfStorage'];
				$lastUpdate = $yr['lastUpdate'];
				$nextUpdate = $yr['nextUpdate'];
				$timeFrom = $yr['timeFrom'];
				$timeTo = $yr['timeTo'];
				$timeperiod = $yr['timeperiod'];
				$symbolId = $yr['symbolId'];
				$temperature = $yr['temperature'];
				$windDirectionDeg = $yr['windDirectionDeg'];
				$windSpeed = $yr['windSpeed'];
				$this->yrList[] = new \Model\Yr($yrPk, $geonamesPk, $timeOfStorage, $lastUpdate, $nextUpdate, $timeFrom, $timeTo, $timeperiod, $symbolId, $temperature, $windDirectionDeg, $windSpeed);
			}
			return $this->yrList;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod i samband med hämtning av YR-prognoser från databasen.');
		}
	}
}