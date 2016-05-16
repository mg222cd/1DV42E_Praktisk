<?php
namespace View;

require_once('./Helpers/Settings.php');

class ForecastView{
	private $goolemapsKey;
	private $settings;
	private $statusMessageWebservices;
	private $forecastHeader;
	private $map;

	public function __construct(){
		$this->settings = new \Settings\Settings();
		$this->goolemapsKey = $this->settings->getKey();
	}

	public function urlIsOk(){
		$url = $_GET['forecast'];
		//Om den är tom
		if ($url == '') {
			return false;
		}

		//kolla om tilde finns:
		$containsTilde = strpos($url, '~');
		// var_dump($containsTilde); die(); <--int (0)
		if ($containsTilde === false) {
			return false;
		}
		//kolla att något står efter tilde
		$explodedUrl = explode('~', $url);
		if ($containsTilde == 0) {
			$afterTilde = $explodedUrl[0];
		}
		$afterTilde = $explodedUrl[1];
		//Om inget finns efter tilde
		if ($afterTilde == '') {
			return false;
		}
		return true;
	}

	public function getGeonameId(){
		$citynameAndGeonameId = $_GET['forecast'];
		$explodedCitynameAndGeonameId = explode('~', $citynameAndGeonameId);
		$geonameId = $explodedCitynameAndGeonameId[1];
		return $geonameId;

	}

	public function getForecastHeader($cityObject){
		$cityname = $cityObject->getName();
		$this->forecastHeader='<h1>Väderprognos för <span class ="darkblueAsInHeader">'.$cityname.'</span>:</h1>';
		return $this->forecastHeader;
	}

	public function getWebserviceStatus($onlineStatusYr, $onlineStatusSmhi){
		if ($onlineStatusYr == true && $onlineStatusSmhi == true) {
			$this->statusMessageWebservices='';
		}
		if ($onlineStatusYr == false || $onlineStatusSmhi == false) {
			$this->statusMessageWebservices='
			<div class="statusmessage">
			Observera! 
			Det verkar som om en eller flera av externa webservices (varifrån Svenskt Väder hämtar sina prognoser) för tillfället ligget nere. 
			På grund av detta är prognosdatat nedan ofullständigt. 
			Svenskt Väder beklagar detta, och ber dig att försöka igen senare.
			</div>
			';
		}
		return $this->statusMessageWebservices;
	}

	public function getForecast($yrList, $smhiList){
		$dateColumn = '';
		$yrColumn = '';
		$smhiColumn = '';
		//gör en asociativ array av allt, och loopa därefter igenom den
		//kom ihåg att ta med felhantering.


		$forecastTable ='
			<div class="col-md-8">
				<p>
					Här kommer prognosdata att visas!
				</p>
				<table class="table table-bordered table table-striped">
				<tr>
					<td>Datum</td>
					<td>YR</td>
					<td>SMHI</td>
				</table>
			</div>
		';
		return $forecastTable;
	}

	public function getMap(){
		$map='
			<div class="col-md-4">
				<div id="map-canvas"></div>
			</div>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$this->goolemapsKey.'"></script>
            <script src="Map.js"></script>
		';
		return $map;
	}

}