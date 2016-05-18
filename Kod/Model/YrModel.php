<?php
namespace Model;

class YrModel{
	private $city;
	private $url;

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
	
	public function testYrWebservice(){
		$testUrlString = 'http://www.yr.no/sted/Sweden/Jämtland/Bruksvallarna/forecast.xml';
		$testData = $this->yrRequest($testUrlString);
		if ($testData == false) {
			return false;
		}
		return true;
	}

	private function getUrl($geonamesObject){
		$country = $geonamesObject->getCountryName();
		$adminName1 = $geonamesObject->getAdminName1();
		$adminName2 = $geonamesObject->getAdminName2();
		$name = $geonamesObject->getName();
		if ($country == 'Norway') {
			$this->url = 'http://www.yr.no/sted/Norge/'.$adminName1.'/'.$adminName2.'/'.$name.'/forecast.xml';
		}
		else{
			$this->url = 'http://www.yr.no/sted/'.$country.'/'.$adminName1.'/'.$name.'/forecast.xml';
		}
		return $this->url;
	}

	
	public function getYrForecast($cityObject){
		$urlRequestYr = $this->getUrl($cityObject);
		$data = $this->yrRequest($urlRequestYr);
		$dataDecoded = new \SimpleXMLElement($data);
		return $dataDecoded;
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