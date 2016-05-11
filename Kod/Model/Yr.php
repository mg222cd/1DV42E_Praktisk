<?php
namespace Model;

class Yr{
	private $yrPk; //inte
	private $geonamesPk; //int
	private $timeOfStorage; //datetime
	private $lastUpdate; //datetime
	private $nextUpdate; //datetime
	private $timeperiod; //int
	private $symbolId; //varchar
	private $temperature; //tinyint
	private $windDirectionDeg; //double
	private $windSpeed; //varchar255

	public function __construct($yrPk, $geonamesPk, $timeOfStorage, $lastUpdate, 
		$nextUpdate, $timeperiod, $symbolId, $temperature, $windDirectionDeg, $windSpeed){

		$this->yrPk = $yrPk;
		$this->geonamesPk = $geonamesPk;
		$this->timeOfStorage = $timeOfStorage;
		$this->lastUpdate = $lastUpdate;
		$this->nextUpdate = $nextUpdate;
		$this->timeperiod = $timeperiod;
		$this->symbolId = $symbolId;
		$this->temperature = $temperature;
		$this->windDirectionDeg = $windDirectionDeg;
		$this->windSpeed = $windSpeed;
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
}