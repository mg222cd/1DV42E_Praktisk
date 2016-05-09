<?php
namespace Model;

class GeonamesModel{
	private $city;

	/*
	public function __construct($city){
		$this->city = $city;
	}
	*/

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

	//Filtrates oyt html and tags
	public function sanitizeText($city){
		$sanitizedText = strip_tags($city);
		$trimmedText = trim($sanitizedText);
		if ($trimmedText != $city) {
			return $trimmedText;
		}
		return $city;
	}

}