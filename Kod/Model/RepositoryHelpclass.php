<?php
namespace Model;


class RepositoryHelpclass {

	public function getCurrentTime(){
		$now = new \DateTime();
		return $now->format('Y-m-d H:i:s');
	}
	
	public function getLastUpdate($yrObject){
		echo '<pre>';
		print_r($yrObject);
		echo '</pre>';
		exit;
		die();

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

}