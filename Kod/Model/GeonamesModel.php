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
		$urlRequestGeonames = 'http://api.geonames.org/searchJSON?name_equals='.$cityWithoutSpaces.'&style=full&maxRows=100&username=marikegrinde';
		$data = $this->geonamesRequest($urlRequestGeonames);
		$dataDecoded = json_decode($data, true);
		return $dataDecoded;
	}

	public function getGeonamesRefined($postedCity, $postedAdminName2, $postedAdminName1, $postedCountry){
		//GÖR KLART DEN HÄR FUNKTIONEN SÅ ATT DEN RETURNERAR RÄTT
		var_dump($postedCity, $postedAdminName2, $postedAdminName1, $postedCountry);die();
		//http://api.geonames.org/searchJSON?name_equals=Flon&q=J%C3%A4mtland&q=sweden&style=full&maxRows=100&username=marikegrinde
		$url = 'http://api.geonames.org/searchJSON?';
		//bygg på url:en med fler parametrar beroende på om dom är NULL eller ej.
		//därefter, gör request, 
		//ta hand om resultatet och decoda på samma sätt som metoden innan. Kom också ihåg hantering om inga träffar skulle hittas (bör fungera på samma vis som i den gamla metoden)
		return null;
	}

	public function getCityByGeonameId($geonameIdSanitized){
		$url = 'http://api.geonames.org/get?geonameId='.$geonameIdSanitized.'&username=marikegrinde&style=full';
		//$url = 'http://api.geonames.org/get?geonameId=980dssjhd0as0s0u&username=marikegrinde&style=full';
		$data = $this->geonamesRequest($url);
		$status = strpos($data, $geonameIdSanitized);
		if ($status === false) {
			return false;
		}
		$dataDecoded = new \SimpleXMLElement($data);
		$geonamesObj = new \model\Geonames(
			null, //GeonamesPk 
			$dataDecoded->geonameId, 
			$dataDecoded->name, 
			$dataDecoded->adminName1, 
			$dataDecoded->adminName2, 
			$dataDecoded->countryName,
			$dataDecoded->fcodeName,
			$dataDecoded->lat,
			$dataDecoded->lng);
		return $geonamesObj;
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

	public function parseCoordinate($coordinate){
		$newCoordinate = (string) $coordinate;
		return $newCoordinate;
	}

}