<?php
namespace Model;

require_once('./Model/Geonames.php');

class GeonamesModel{
	private $city;
	private $geonamesList = array();


	public function geonamesRequest($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept' => 'application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	public function testGeonames(){
		$testUrlString = 'http://api.geonames.org/searchJSON?name=Bruksvallarna&style=full&maxRows=100&username=marikegrinde';
		$testData = $this->geonamesRequest($testUrlString);
		if ($testData == false) {
			return false;
		}
		return true;
	}

	public function getGeonames($city){
		//mellanslags-fix
		$cityWithoutSpaces = preg_replace('/\s+/', '%20', $city);
		$urlRequestGeonames = 'http://api.geonames.org/searchJSON?name='.$cityWithoutSpaces.'&style=full&maxRows=100&username=marikegrinde';
		$data = $this->geonamesRequest($urlRequestGeonames);
		$dataDecoded = json_decode($data, true);
		return $dataDecoded;
	}

	public function getCityByGeonameId($geonameIdSanitized){
		//$url = 'http://api.geonames.org/get?geonameId='.$geonameIdSanitized.'&username=marikegrinde&style=full';
		$url = 'http://api.geonames.org/get?geonameId=980dssjhd0as0s0u&username=marikegrinde&style=full';
		$data = $this->geonamesRequest($url);
		$dataDecoded = new \SimpleXMLElement($data);
		var_dump($dataDecoded);
		/*
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit;
		*/
		if ($data == ' ') {
			var_dump('INNE');die();
			return false;
		}
		var_dump($data);die();
	}

	//Filtrates oyt html and tags
	public function sanitizeText($city){
		$sanitizedText = strip_tags($city);
		$trimmedText = trim($sanitizedText);
		if ($trimmedText != $city) {
			return $trimmedText;
		}
		return $city;
	}

	public function getGeonamesObject($geonamesArr){
		unset($this->geonamesList);
		$this->geonamesList = array();
		/*
		echo '<pre>';
		print_r($geonamesArr);
		echo '</pre>';
		exit;
		die();
		*/

		foreach ($geonamesArr['geonames'] as $geoname) {
			$geonames = new \model\Geonames(
			null, //GeonamesPk 
			$geoname['geonameId'], 
			$geoname['name'], 
			$geoname['adminName1'], 
			$geoname['adminName2'], 
			$geoname['countryName'],
			$geoname['fcodeName'],
			$geoname['lat'],
			$geoname['lng']);
			$this->geonamesList [] = $geonames;
		}

		return $this->geonamesList;
	}

}