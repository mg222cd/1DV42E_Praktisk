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
				'yrWindDir' => $yrRow->getWindDirectionDeg(),
				'yrWindSpeed' => $yrRow->getWindSpeed(),
				'yrPrec' => $yrRow->getPrecipitation(),
				'yrPressure' => $yrRow->getPressure()
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

	public function getSmhiOnly(){
		$list = array();
		foreach ($this->smhi as $smhiRow) {
				$time = $smhiRow->getValidTime();
				$now = new \DateTime();
				if ($time > $now->format('Y-m-d H:i:s')) {
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
					$list[] = $smhi;
				}
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
			return '<div><b>Idag</b></div> <div>' .$explodedDateTime[1].'</div>';
		}
		if ($dateString == $tomorrow->format('Y-m-d')) {
			return '<div><b>Imorgon</b></div> <div>' .$explodedDateTime[1].'</div>';
		}
		else {
			$weekdayEn= date('l', strtotime( $dateString));
			$weekdaysEn = array ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
			$weekdaysSwe = array ('Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag');

			$weekdaySwe = str_replace($weekdaysEn, $weekdaysSwe, $weekdayEn);
			return '<div><b>'.$weekdaySwe.'</b></div><div><b>'.$dateString.'</b></div> <div>' .$explodedDateTime[1].'</div>';
		}
	}

	public function getWindName($windSpeed){
		if ($windSpeed == 0 || $windSpeed <= 0.2) {
			return 'Lugnt';
		}
		if ($windSpeed >= 0.3 && $windSpeed <= 3.3) {
			return 'Svag vind';
		}
		if ($windSpeed >= 3.4 && $windSpeed <= 7.9) {
			return 'Måttlig vind';
		}
		if ($windSpeed >= 8.0 && $windSpeed <= 13.8) {
			return 'Frisk vind';
		}
		if ($windSpeed >= 13.9 && $windSpeed <= 24.4) {
			return 'Hård vind';
		}
		if ($windSpeed >= 24.5 && $windSpeed <= 32.6) {
			return 'Storm';
		}
		if ($windSpeed >= 32.7) {
			return 'Orkan';
		}
		else{
			return'';
		}
	}

	public function getWindDir($windDir){
		if ($windDir >= 337.5 || $windDir <= 22.5) {
			return 'norr';
		}
		if ($windDir >= 22.6 && $windDir <= 67.5) {
			return 'nordost';
		}
		if ($windDir >= 67.6 && $windDir <= 112.5) {
			return 'öster';
		}
		if ($windDir >= 112.6 && $windDir <= 157.5) {
			return 'sydost';
		}
		if ($windDir >= 157.6 && $windDir <= 202.5) {
			return 'söder';
		}
		if ($windDir >= 202.6 && $windDir <= 247.5) {
			return 'sydväst';
		}
		if ($windDir >= 247.6 && $windDir <= 292.5) {
			return 'väster';
		}
		if ($windDir >= 292.6 && $windDir <= 337.5) {
			return 'nordväst';
		}
	}

	public function getPrecipitationCategory($smhiPrecCat){
		/*
		0 no, 1 snow, 2 snow and rain, 3 rain, 4 drizzle, 5, freezing rain, 6 freezing drizzle
		*/
		if ($smhiPrecCat == 0) {
			return '';
		}
		if ($smhiPrecCat == 1) {
			return '(snö)';
		}
		if ($smhiPrecCat == 2) {
			return '(snöblandat regn)';
		}
		if ($smhiPrecCat == 3) {
			return '(regn)';
		}
		if ($smhiPrecCat == 4) {
			return '(duggregn)';
		}
		if ($smhiPrecCat == 5) {
			return '(underkylt regn)';
		}
		if ($smhiPrecCat == 6) {
			return '(underkylt duggregn)';
		}
		else{
			return '';
		}
	}


}