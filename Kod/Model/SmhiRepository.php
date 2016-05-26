<?php
namespace Model;

require_once('./Model/DatabaseConnection.php');
require_once('./Model/Smhi.php');
require_once('./Model/RepositoryHelpclass.php');

class SmhiRepository extends DatabaseConnection{
	private $helper;
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
	
	public function addForecast($smhiDecoded, $geonamesPk){
		//rensa array
		unset($this->smhiList);
		$this->smhiList = array();
		//prognosens datumparametrar
		$currentTime = $this->helper->getCurrentTime();;
		$referenceTime = $this->helper->smhiDateTimeFormat($smhiDecoded['referenceTime']);
		//lagrar varje prognos i som ett smhi-objekt.
		$forecasts = (array) $smhiDecoded['timeseries'];
		foreach ($forecasts as $forecast) {
				//fixar fältet med tiden som prognosen gäller.
				$validTime = $this->helper->smhiDateTimeFormat($forecast['validTime']);
				//bara prognoser nyare än just nu.
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
						$precipitationIntensity = $forecast['pit'],
						$categoryOfPrecipitation = $forecast['pcat']
						);
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
		return true;
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

	public function isThereValidForecastInDatabase($geonamesObject){
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
			$now = new \DateTime();
			foreach ($query->fetchAll() as $smhi) {
				$expirationDate = $this->helper->getSmhiExpirationDate($smhi['referenceTime']);
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
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då prognoser skulle tas bort ur databasen.');
		}
		return true;	
	}

	public function getForecast($geonamesObject){
		$geonamesPk = $geonamesObject->getGeonamesPk();
		//rensa array
		unset($this->smhiList);
		$this->smhiList = array();

		try{
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
			foreach ($query->fetchAll() as $smhi) {
				$smhiPk = $smhi['smhiPk'];
				$geonamesPk = $smhi['geonamesPk'];
				$timeOfStorage = $smhi['timeOfStorage'];
				$referenceTime = $smhi['referenceTime'];
				$validTime = $smhi['validTime'];
				$temperature = $smhi['temperature'];
				$windDirection = $smhi['windDirection'];
				$windVelocity = $smhi['windVelocity'];
				$windGust = $smhi['windGust'];
				$pressure = $smhi['pressure'];
				$relativeHumidity = $smhi['relativeHumidity'];
				$visibility = $smhi['visibility'];
				$totalCloudCover = $smhi['totalCloudCover'];
				$probabilityThunderstorm = $smhi['probabilityThunderstorm'];
				$precipitationIntensity = $smhi['precipitationIntensity'];
				$categoryOfPrecipitation = $smhi['categoryOfPrecipitation'];
				$this->smhiList[] = new \Model\Smhi($smhiPk, $geonamesPk, $timeOfStorage, $referenceTime, $validTime, $temperature, 
					$windDirection,$windVelocity, $windGust, $pressure, $relativeHumidity, $visibility, $totalCloudCover, 
					$probabilityThunderstorm, $precipitationIntensity, $categoryOfPrecipitation);
			}
			return $this->smhiList;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod i samband med hämtning av YR-prognoser från databasen.');
		}
	}

}