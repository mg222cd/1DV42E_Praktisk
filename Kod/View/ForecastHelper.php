<?php
namespace View;

class ForecastHelper{
	private $yr;
	private $smhi;
	private $lastLoopedDate;

	public function __construct($yrObj, $smhiObj){
		$this->yr = $yrObj;
		$this->smhi =$smhiObj;
	}


	public function getSortedList(){
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
		return $list;
	}

	public function getWeekday($dateAndTime){
		$this->lastLoopedDate = $dateAndTime;
		//dagens datum i formatet YYYY-MM-DD
		$today = new \DateTime();
		//inskickat datum i formatet YYYY-MM-DD
		$explodedDateTime = explode(' ', $dateAndTime);
		$dateString = $explodedDateTime[0];
		//imorgon i formatet YYYY-MM-DD
		$tomorrow = new \DateTime();
		$tomorrow->add(new \DateInterval('P1D'));
		//Jämförelse
		if ($dateString == $today->format('Y-m-d')) {
			return '<b>Idag</b> kl ' .$explodedDateTime[1];
		}
		if ($dateString == $tomorrow->format('Y-m-d')) {
			return '<b>Imorgon</b> kl ' .$explodedDateTime[1];
		}
		else {
			$weekdayEn= date('l', strtotime( $dateString));
			$weekdaysEn = array ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
			$weekdaysSwe = array ('Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag');

			$weekdaySwe = str_replace($weekdaysEn, $weekdaysSwe, $weekdayEn);
			return '<b>'.$weekdaySwe.'</b>' . $explodedDateTime[1];
		}
	}


}