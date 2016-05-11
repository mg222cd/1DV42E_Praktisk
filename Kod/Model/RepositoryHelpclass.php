<?php
namespace Model;


class RepositoryHelpclass {

	public function getCurrentTime(){
		$now = new \DateTime();
		$now->format('Y-m-d H:i:s');
		return $now;
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
		$date->format('Y-m-d H:i:s');

		return $date;
	}

}