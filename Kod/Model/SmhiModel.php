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
		curl_close($ch);
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

	/*
	public function getYrForecast($cityObject){
		$url = $this->getUrl();
		$data = $this->yrRequest($url);
		$xmlParser = xml_parser_create();
		xml_parse_into_struct($xmlParser, $data, $values, $index); 
		return $xmlParser;
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