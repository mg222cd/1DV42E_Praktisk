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
		//gör request, om resultatet funkar, return true, annars, return false.
		$data = $this->geonamesRequest($testUrlString);
		//string(37) "{"totalResultsCount":0,"geonames":[]}"
		//string(846) "{"totalResultsCount":1,"geonames":[{"timezone":{"gmtOffset":1,"timeZoneId":"Europe/Stockholm","dstOffset":2},"bbox":{"east":12.446398113320699,"south":62.6361743602987,"north":62.637973090048995,"west":12.442484523703227},"asciiName":"Bruksvallarna","countryId":"2661886","fcl":"P","score":57.229244232177734,"adminId2":"2707737","countryCode":"SE","adminId1":"2703330","lat":"62.63707","fcode":"PPL","continentCode":"EU","adminCode2":"2361","adminCode1":"07","lng":"12.44444","geonameId":2719001,"toponymName":"Bruksvallarna","population":66,"adminName5":"","adminName4":"","adminName3":"","alternateNames":[{"name":"http://en.wikipedia.org/wiki/Bruksvallarna","lang":"link"}],"adminName2":"HÃ¤rjedalens Kommun","name":"Bruksvallarna","fclName":"city, village,...","countryName":"Sweden","fcodeName":"populated place","adminName1":"JÃ¤mtland"}]}"
		var_dump($data);die();
	}


}