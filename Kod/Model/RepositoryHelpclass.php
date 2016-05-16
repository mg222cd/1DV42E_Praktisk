<?php
namespace Model;


class RepositoryHelpclass {

	public function getCurrentTime(){
		$now = new \DateTime();
		return $now->format('Y-m-d H:i:s');
	}

	public function smhiDateTimeFormat($dateTimeString){
		$dateTimeString = rtrim($dateTimeString, "Z");
		$exploded = explode('T', $dateTimeString);
		$date = new \DateTime($exploded[0]);
		$time = explode(':', $exploded[1]);
		$date->setTime($time[0], $time[1], $time[2]);
		return $date->format('Y-m-d H:i:s');
	}

	public function getSmhiExpirationDate($referenceTime){
		$date = new \DateTime($referenceTime);
		$date->add(new \DateInterval('PT3H'));
		return $date->format('Y-m-d H:i:s');
	}
	
	public function getLastUpdate($yrObject){
		//hämta rätt fält från obj
		$field = (string) $yrObject->meta->lastupdate;
		$explodedField = explode('T', $field);
		//Sätter datumet på plats
		$date = new \DateTime($explodedField[0]);
		//Sorterar tidsfält
		$time = explode(':', $explodedField[1]);
		//Sätter tiden på plats
		$date->setTime($time[0], $time[1], $time[2]);
		return $date->format('Y-m-d H:i:s');
	}

	public function getNextUpdate($yrObject){
		//hämta rätt fält från obj
		$field = (string) $yrObject->meta->nextupdate;
		$explodedField = explode('T', $field);
		//Sätter datumet på plats
		$date = new \DateTime($explodedField[0]);
		//Sorterar tidsfält
		$time = explode(':', $explodedField[1]);
		//Sätter tiden på plats
		$date->setTime($time[0], $time[1], $time[2]);
		return $date->format('Y-m-d H:i:s');
	}

	public function getTimeFrom($yrForecastArr){
		//hämta rätt fält från arr
		$timestring = $yrForecastArr["@attributes"]["from"];
		$explodedField = explode('T', $timestring);
		//Sätter datumet på plats
		$date = new \DateTime($explodedField[0]);
		//Sorterar tidsfält
		$time = explode(':', $explodedField[1]);
		//Sätter tiden på plats
		$date->setTime($time[0], $time[1], $time[2]);
		return $date->format('Y-m-d H:i:s');
	}

	public function getTimeTo($yrForecastArr){
		//hämta rätt fält från arr
		$timestring = $yrForecastArr["@attributes"]["to"];
		$explodedField = explode('T', $timestring);
		//Sätter datumet på plats
		$date = new \DateTime($explodedField[0]);
		//Sorterar tidsfält
		$time = explode(':', $explodedField[1]);
		//Sätter tiden på plats
		$date->setTime($time[0], $time[1], $time[2]);
		return $date->format('Y-m-d H:i:s');
	}

}