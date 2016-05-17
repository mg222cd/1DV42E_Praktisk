<?php
namespace View;

class ForecastHelper{
	private $yr;
	private $smhi;

	public function __construct($yrObj, $smhiObj){
		$this->yr = $yrObj;
		$this->smhi =$smhiObj;
	}


	public function getSortedList(){
		//$list = array('dates' => '');
		$list = array();
		foreach ($this->yr as $yrRow) {
			$timeFrom = $yrRow->getTimeFrom();
			$timeTo = $yrRow->getTimeTo();
			$values = array(
				'dateFrom' => $timeFrom,
				'dateTo' => $timeTo,
				'timeperiod' => $yrRow->getTimePeriod(),
				'yrSymbol' => $yrRow->getSymbolId(),
				'yrTemp' => $yrRow->getTemperature(),
				'yrwindDir' => $yrRow->getWindDirectionDeg(),
				'yrWindSpeed' => $yrRow->getWindSpeed()
				);
			foreach ($this->smhi as $smhiRow) {
				$time = $smhiRow->getValidTime();
					/*
					public function getProbabilityThunderstorm(){
					public function getPrecipitationIntensity(){
					public function getCategoryOfPrecipitation(){
					*/

				if ($time == $timeFrom || ($time > $timeFrom && $time < $timeTo) && ( ! isset($values['smhi']) || ! in_array($time, $values['smhi'])) ){
					$smhi = array(
						'smhiTime' => $time,
						'smhiTemp' => $smhiRow->getTemperature(),
						'smhiWindDir' => $smhiRow->getWindDirection(),
						'smhiWindSpeed' => $smhiRow->getWindVelocity(),
						'smhiWindGust' => $smhiRow->getWindGust(),
						'smhiPressure' => $smhiRow->getPressure(),
						'smhiHumidity' => $smhiRow->getRelativeHumidity(),
						'smhiVisibility' => $smhiRow->getVisibility(),
						'smhiCloudCover' => $smhiRow->getTotalCloudCover(),
						'smhiProbThunder' => $smhiRow->getProbabilityThunderstorm(),
						'smhiPrecIntens' => $smhiRow->getPrecipitationIntensity(),
						'smhiPrecCat' => $smhiRow->getCategoryOfPrecipitation()
						);
					$values[] = $smhi;
				}
			}
			$list[] = $values;
		}
		echo '<pre>';
		print_r($list);
		echo '</pre>';
		exit;
	}


}