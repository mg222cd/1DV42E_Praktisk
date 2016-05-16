<?php
namespace Model;

require_once('./Model/DatabaseConnection.php');
require_once('./Model/Smhi.php');
require_once('./Model/RepositoryHelpclass.php');

class SmhiRepository extends DatabaseConnection{
	private $helper;
	private $smhiObject;
	private $smhiList = array();
	private $smhiPk = 'yrPk';
	private $geonamesPk = 'geonamesPk';
	private $timeOfStorage = 'timeOfStorage';
	private $referenceTime = 'referenceTime';
	private $validTime = 'validTime';
	private $temperature = 'temperature';
	private $windDirection = 'windDirection';
	private $windVelocity = 'windVelocity';
	private $windGust = 'windGust';
	private $pressure = 'pressure';
	private $relativeHumidity = 'relativeHumidity';
	private $visibility = 'visibility';
	private $totalCloudCover = 'totalCloudCover';
	private $probabilityThunderstorm = 'probabilityThunderstorm';
	private $precipitationIntensity = 'precipitationIntensity';
	private $categoryOfPrecipitation = 'categoryOfPrecipitation';
	
	public function __construct(){
		$this->dbTable = 'smhi';
		$this->helper = new \Model\RepositoryHelpclass();
	}
	
	public function addForecast($smhiObject, $geonamesPk){
		$smhiDecoded = json_decode($smhiObject, true);

		//prognosens datumparametrar
		$currentTime = $this->helper->getCurrentTime();;
		$referenceTime = $this->helper->smhiDateTimeFormat($smhiDecoded['referenceTime']);
		
		//lagrar varje prognos i som ett smhi-objekt.
		$forecasts = (array) $smhiDecoded['timeseries'];

		foreach ($forecasts as $forecast) {
				//fixar fältet med tiden som prognosen gäller.
				$validTime = $this->helper->smhiDateTimeFormat($forecast['validTime']);
				//bara prognoser nyare än just nu.
				if ($validTime > $currentTime) {
					$this->smhiList[] = new \Model\Smhi(
						null, // $smhiPk;
						$geonamesPk, 
						$timeOfStorage = $currentTime,
						$referenceTime,
						$validTime,
						$temperature = $forecast['t'],
						$windDirection = $forecast['wd'],
						$windVelocity = $forecast['ws'],
						$windGust = $forecast['gust'],
						$pressure = $forecast['msl'],
						$relativeHumidity = $forecast['r'],
						$visibility = $forecast['vis'],
						$totalCloudCover = $forecast['tcc'],
						$probabilityThunderstorm = $forecast['tstm'],
						$precipitationIntensity = $forecast['pis'],
						$categoryOfPrecipitation = $forecast['pcat']
						);
				}
		}

		foreach ($this->smhiList as $value) {
			try{
				$db = $this->connection();
				
				$sql = "INSERT INTO $this->dbTable ("
					.$this->geonamesPk.","
					.$this->timeOfStorage.","
					.$this->referenceTime.","
					.$this->validTime.","
					.$this->temperature.","
					.$this->windDirection.","
					.$this->windVelocity.","
					.$this->windGust.","
					.$this->pressure.","
					.$this->relativeHumidity.","
					.$this->visibility.","
					.$this->totalCloudCover.","
					.$this->probabilityThunderstorm.","
					.$this->precipitationIntensity.","
					.$this->categoryOfPrecipitation.")
	               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$params = array (
					$value->getGeonamesPk(),
					$value->getTimeOfStorage(),
					$value->getReferenceTime(),
					$value->getValidTime(),
					$value->getTemperature(),
					$value->getWindDirection(),
					$value->getWindVelocity(),
					$value->getWindGust(),
					$value->getPressure(),
					$value->getRelativeHumidity(),
					$value->getVisibility(),

					$value->getTotalCloudCover(),
					$value->getProbabilityThunderstorm(),
					$value->getPrecipitationIntensity(),
					$value->getCategoryOfPrecipitation());
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
			$sql = "SELECT $this->dbTable.smhiPk, $this->dbTable.geonamesPk, $this->dbTable.timeOfStorage, $this->dbTable.referenceTime, 
							$this->dbTable.validTime, $this->dbTable.temperature, $this->dbTable.windDirection, $this->dbTable.windVelocity, 
							$this->dbTable.windGust, $this->dbTable.pressure, $this->dbTable.relativeHumidity, $this->dbTable.visibility,
							$this->dbTable.totalCloudCover, $this->dbTable.probabilityThunderstorm, $this->dbTable.precipitationIntensity, 
							$this->dbTable.categoryOfPrecipitation
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

	/*
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
	*/

	/*
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
	*/

	/*
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
	*/
}