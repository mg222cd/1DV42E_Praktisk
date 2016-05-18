<?php
namespace View;

require_once('./Helpers/Settings.php');
require_once('./View/ForecastHelper.php');

class ForecastView{
	private $goolemapsKey;
	private $settings;
	private $statusMessageWebservices;
	private $forecastHeader;
	private $map;
	private $helper;

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
		//Hjälpfunktion
		$this->helper = new \View\ForecastHelper($yrList, $smhiList);
		$list = $this->helper->getSortedList();
		$tableRow = '';

		/*
		echo '<pre>';
		print_r($list);
		echo '</pre>';
		exit;
		die();
		*/

		foreach ($list as $timeInterval) {
			$datecolumn = $this->helper->getWeekday($timeInterval['dateFrom']);
			$symbolIdYr = $timeInterval['yrSymbol'];
			$windDirYr = $this->helper->getWindDir($timeInterval['yrWindDir']);
			$windNameYr = $this->helper->getWindName($timeInterval['yrWindSpeed']);
			$tableRow .= '
			<tr>
				<td>
				'.$datecolumn. '
				</td>
				<td>
				<img src="http://symbol.yr.no/grafikk/sym/b38/'.$symbolIdYr.'.png" alt="vädersymbol från yr.no" title="vädersymbol från yr.no">
				<div class="infoInTable">
				'.$timeInterval['yrTemp'].' ° C
				</div>
				<div class="infoInTable">
				<div> 
				'.$timeInterval['yrWindSpeed'].' m/s
				<div>
				<div> 
				'.$windNameYr.'
				<div>
				<div> 
				'.$timeInterval['yrWindDir'].$windDirYr.' vindriktning.
				<div>
				</div>
				</td>
				<td>
				Här kommer SMHI senare
				</td>
			</tr>';
		}


		$forecastTable ='
			<div class="col-md-8">
				<p>
					Här kommer prognosdata att visas!
				</p>
				<table class="table">
				<tr>
					<td></td>
					<td>
					<a href="http://www.yr.no">
					<img class="yr" src="http://www.yr.no/grafikk/yr-logo.png" alt="logo yr" title="logo yr">
					</a>
					</td>
					<td>
					<a href="http://www.smhi.se">
					<img class="smhi" src="http://www.smhi.se/polopoly_fs/1.1108.1398236874!/image/SMHIlogo.png_gen/derivatives/Original/SMHIlogo.png" alt="logo smhi" title="logo smhi">
					</a>
					</td>
				</tr>'
				.$tableRow.
				'</table>
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