<?php
namespace Model;

class SmhiModel{
	private $city;
	private $url;


	public function smhiRequest($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept' => 'application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		$http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($http_status_code != 200) {
			return false;
		}
		return $data;
	}
	
	public function testSmhiWebservice(){
		$testUrlString = 'http://opendata-download-metfcst.smhi.se/api/category/pmp1.5g/version/1/geopoint/lat/58.59/lon/16.18/data.json';
		$testData = $this->smhiRequest($testUrlString);
		if ($testData == false) {
			return false;
		}
		return true;
	}

	public function getSmhiForecast($cityObject){
		$lat = $cityObject->getLat();
		$lng = $cityObject->getLng();
		$urlRequestSmhi = 'http://opendata-download-metfcst.smhi.se/api/category/pmp1.5g/version/1/geopoint/lat/'.$lat.'/lon/'.$lng.'/data.json';
		$data = $this->smhiRequest($urlRequestSmhi);
		$smhiDecoded = json_decode($data, true);
		if ($smhiDecoded == null || $data == false) {
			return false;
		}
		return $smhiDecoded;
	}

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