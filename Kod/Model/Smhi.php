<?php
namespace Model;

class Smhi{

	private $smhiPk; //inte
	private $geonamesPk; //int
	private $timeOfStorage; //datetime
	private $referenceTime; //datetime
	private $validTime; //datetime
	private $temperature; //int
	private $windDirection; //float
	private $windVelocity; //int
	private $windGust; //varchar
	private $pressure; //varchar
	private $relativeHumidity; //int
	private $visibility; //string
	private $totalCloudCover; //int
	private $probabilityThunderstorm; //int
	private $precipitationIntensity; //varchar
	private $categoryOfPrecipitation; //int

	public function __construct($smhiPk, $geonamesPk, $timeOfStorage, $referenceTime, $validTime, $temperature, $windDirection,
		$windVelocity, $windGust, $pressure, $relativeHumidity, $visibility, $totalCloudCover, $probabilityThunderstorm, 
		$precipitationIntensity, $categoryOfPrecipitation){

		$this->smhiPk = $smhiPk;
		$this->geonamesPk = $geonamesPk;
		$this->timeOfStorage = $timeOfStorage;
		$this->referenceTime = $referenceTime;
		$this->validTime = $validTime;
		$this->temperature = $temperature;
		$this->windDirection = $windDirection;
		$this->windVelocity = $windVelocity;
		$this->windGust = $windGust;
		$this->pressure = $pressure;
		$this->relativeHumidity = $relativeHumidity;
		$this->visibility = $visibility;
		$this->totalCloudCover = $totalCloudCover;
		$this->probabilityThunderstorm = $probabilityThunderstorm;
		$this->precipitationIntensity = $precipitationIntensity;
		$this->categoryOfPrecipitation = $categoryOfPrecipitation;

	}

	public function getSmhiPk(){
		return $this->smhiPk;
	}

	public function getGeonamesPk(){
		return $this->geonamesPk;
	}

	public function getTimeOfStorage(){
		return $this->timeOfStorage;
	}

	public function getReferenceTime(){
		return $this->referenceTime;
	}

	public function getValidTime(){
		return $this->validTime;
	}

	public function getTemperature(){
		return $this->temperature;
	}

	public function getWindDirection(){
		return $this->windDirection;
	}

	public function getWindVelocity(){
		return $this->windVelocity;
	}

	public function getWindGust(){
		return $this->windGust;
	}

	public function getPressure(){
		return $this->pressure;
	}

	public function getRelativeHumidity(){
		return $this->relativeHumidity;
	}

	public function getVisibility(){
		return $this->visibility;
	}

	public function getTotalCloudCover(){
		return $this->totalCloudCover;
	}

	public function getProbabilityThunderstorm(){
		return $this->probabilityThunderstorm;
	}

	public function getPrecipitationIntensity(){
		return $this->precipitationIntensity;
	}
	public function getCategoryOfPrecipitation(){
		return $this->categoryOfPrecipitation;
	}
}