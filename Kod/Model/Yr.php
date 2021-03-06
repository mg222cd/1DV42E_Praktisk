<?php
namespace Model;

class Yr{
	private $yrPk; //inte
	private $geonamesPk; //int
	private $timeOfStorage; //datetime
	private $lastUpdate; //datetime
	private $nextUpdate; //datetime
	private $timeFrom; //datetime
	private $timeTo; //datetime
	private $timeperiod; //int
	private $symbolId; //varchar
	private $temperature; //tinyint
	private $windDirectionDeg; //double
	private $windSpeed; //varchar255
	private $precipitation; //int
	private $pressure; 

	public function __construct($yrPk, $geonamesPk, $timeOfStorage, $lastUpdate, $nextUpdate, $timeFrom, $timeTo,
		$timeperiod, $symbolId, $temperature, $windDirectionDeg, $windSpeed, $precipitation, $pressure){
		$this->yrPk = $yrPk;
		$this->geonamesPk = $geonamesPk;
		$this->timeOfStorage = $timeOfStorage;
		$this->lastUpdate = $lastUpdate;
		$this->nextUpdate = $nextUpdate;
		$this->timeFrom = $timeFrom;
		$this->timeTo = $timeTo;
		$this->timeperiod = $timeperiod;
		$this->symbolId = $symbolId;
		$this->temperature = $temperature;
		$this->windDirectionDeg = $windDirectionDeg;
		$this->windSpeed = $windSpeed;
		$this->precipitation = $precipitation;
		$this->pressure = $pressure;
	}

	public function getYrPk(){
		return $this->yrPk;
	}

	public function getGeonamesPk(){
		return $this->geonamesPk;
	}

	public function getTimeOfStorage(){
		return $this->timeOfStorage;
	}

	public function getLastUpdate(){
		return $this->lastUpdate;
	}

	public function getNextUpdate(){
		return $this->nextUpdate;
	}

	public function getTimeFrom(){
		return $this->timeFrom;
	}

	public function getTimeTo(){
		return $this->timeTo;
	}

	public function getTimeperiod(){
		return $this->timeperiod;
	}

	public function getSymbolId(){
		return $this->symbolId;
	}

	public function GetTemperature(){
		return $this->temperature;
	}

	public function getWindDirectionDeg(){
		return $this->windDirectionDeg;
	}

	public function getWindSpeed(){
		return $this->windSpeed;
	}

	public function getPrecipitation(){
		return $this->precipitation;
	}

	public function getPressure(){
		return $this->pressure;
	}
}