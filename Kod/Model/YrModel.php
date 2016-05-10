<?php
namespace Model;

class YrModel{
	private $city;

	public function yrRequest($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept' => 'application/xml; charset=utf-8'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	public function testYr(){
		/*
		"http://www.yr.no/sted/{0}/{1}/{2}/forecast.xml", 
		geoname.countryName, geoname.adminName1, geoname.name
		*/
		$testUrlString = 'http://www.yr.no/sted/Sweden/Jämtland/Bruksvallarna/forecast.xml';
		$testData = $this->yrRequest($testUrlString);
		if ($testData == false) {
			return false;
		}
		return true;
	}

	/*
	public function getGeonames($city){
		//mellanslags-fix
		$cityWithoutSpaces = preg_replace('/\s+/', '%20', $city);
		$urlRequestGeonames = 'http://api.geonames.org/searchJSON?name='.$cityWithoutSpaces.'&style=full&maxRows=100&username=marikegrinde';
		$data = $this->geonamesRequest($urlRequestGeonames);
		$dataDecoded = json_decode($data, true);
		return $dataDecoded;
	}
	*/

	//Filtrates oyt html and tags
	public function sanitizeText($forecast){
		$sanitizedText = strip_tags($forecast);
		$trimmedText = trim($sanitizedText);
		if ($trimmedText != $forecast) {
			return $trimmedText;
		}
		return $forecast;
	}

}