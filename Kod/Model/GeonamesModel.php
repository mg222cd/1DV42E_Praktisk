<?php
namespace Model;

class GeonamesModel{
	private $city;

	public function __construct($city){
		$this->city = $city;
	}

	public function geonamesRequest($url){
		//curl
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


}