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
			Vänligen försök igen senare.
			</div>
			';
		}
		return $this->statusMessageWebservices;
	}

	public function getForecast($yrList, $smhiList){
		if (count($yrList) < 1 && count($smhiList) < 1) {
			$this->statusMessageWebservices='
			<div class="statusmessage">
			Inga prognosresultat funna för angiven stad.
			</div>
			';
			return $this->statusMessageWebservices;
		}
		if (count($yrList) < 1) {
			$smhiForecast = $this->getSmhiForecastOnly($smhiList);
			return $smhiForecast;
		}
		//Hjälpfunktion
		$this->helper = new \View\ForecastHelper($yrList, $smhiList);
		$list = $this->helper->getSortedList();
		$tableRow = '';

		//varje rad i tabellen
		foreach ($list as $timeInterval) {
			$datecolumn = $this->helper->getWeekday($timeInterval['dateFrom']);
			$symbolIdYr = $timeInterval['yrSymbol'];
			$windDirYr = $this->helper->getWindDir($timeInterval['yrWindDir']);
			$windNameYr = $this->helper->getWindName($timeInterval['yrWindSpeed']);
			$smhi = '';
			
			//Smhi-kolumnen
			for ($i = 0; $i <= 0; $i++) {
				if (isset($timeInterval[$i])) {
					$smhi .= '
					<div class="infoInTableSmhi">
					<div>'
					.round($timeInterval[$i]['smhiTemp']). ' ° C
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Vind:
					</div>
					<div>'
					.$timeInterval[$i]['smhiWindSpeed'].' m/s ('.$timeInterval[$i]['smhiWindGust'].' m/s)
					</div>
					<div>
					'.$this->helper->getWindName($timeInterval[$i]['smhiWindSpeed']).' från '.$this->helper->getWindDir($timeInterval[$i]['smhiWindDir']).'
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Nederbörd:
					</div>
					<div>
					'.$timeInterval[$i]['smhiPrecIntens'].' mm '.$this->helper->getPrecipitationCategory($timeInterval[$i]['smhiPrecCat']).'
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Lufttryck:
					</div>
					<div>
					'.$timeInterval[$i]['smhiPressure'].' hPa
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Relativ luftfuktighet:
					</div>
					<div>
					'.$timeInterval[$i]['smhiHumidity'].'%
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Sikt:
					</div>
					<div>
					'.$timeInterval[$i]['smhiVisibility'].' km
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Total molnmängd:
					</div>
					<div>
					'.$timeInterval[$i]['smhiCloudCover'].'/8
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Sannolikhet för åska:
					</div>
					<div>
					'.$timeInterval[$i]['smhiProbThunder'].'/8
					</div>
					</div>
					';
				}
				else{
					$smhi .= 'Data saknas från SMHI';
				}
			}

	
			$tableRow .= '
			<tr>
				<td>
				'.$datecolumn. '
				<img src="http://symbol.yr.no/grafikk/sym/b38/'.$symbolIdYr.'.png" alt="vädersymbol från yr.no" title="vädersymbol från yr.no">
				</td>
				<td>
				<div class="infoInTable">
				'.$timeInterval['yrTemp'].' ° C
				</div>
				<div class="infoInTable">
				<div>
				Vind:
				</div>
				<div> 
				'.$timeInterval['yrWindSpeed'].' m/s
				</div>
				<div> 
				'.$windNameYr.' från '.$windDirYr.'
				</div>
				</div>
				
				<div class="infoInTable">
				<div>
				Nederbörd:
				</div>
				<div>
				'.$timeInterval['yrPrec'].' mm
				</div>
				</div>

				<div class="infoInTable">
				<div>
				Lufttryck:
				</div>
				<div>
				'.$timeInterval['yrPressure'].' hPa
				</div>
				</div>  
				</td>
				<td>'.
				$smhi
				.'</td>
			</tr>';
		}


		$forecastTable ='
		<div class ="row">
			<div class="col-md-6">
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

	public function getSmhiForecastOnly($smhiList){
		//Hjälpfunktion
		$this->helper = new \View\ForecastHelper($yr = null, $smhiList);
		$list = $this->helper->getSmhiOnly();
		/*
		echo '<pre>';
		print_r($list);
		echo '</pre>';
		exit;
		*/
		$tableRow = '';

		//varje rad i tabellen
		foreach ($list as $timeInterval) {
			$datecolumn = $this->helper->getWeekday($timeInterval['smhiTime']);
			$smhi = '';
			//Smhi-kolumnen
					$smhi .= '
					<div class="infoInTableSmhi">
					<div>'
					.round($timeInterval['smhiTemp']). ' ° C
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Vind:
					</div>
					<div>'
					.$timeInterval['smhiWindSpeed'].' m/s ('.$timeInterval['smhiWindGust'].' m/s)
					</div>
					<div>
					'.$this->helper->getWindName($timeInterval['smhiWindSpeed']).' från '.$this->helper->getWindDir($timeInterval['smhiWindDir']).'
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Nederbörd:
					</div>
					<div>
					'.$timeInterval['smhiPrecIntens'].' mm '.$this->helper->getPrecipitationCategory($timeInterval['smhiPrecCat']).'
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Lufttryck:
					</div>
					<div>
					'.$timeInterval['smhiPressure'].' hPa
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Relativ luftfuktighet:
					</div>
					<div>
					'.$timeInterval['smhiHumidity'].'%
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Sikt:
					</div>
					<div>
					'.$timeInterval['smhiVisibility'].' km
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Total molnmängd:
					</div>
					<div>
					'.$timeInterval['smhiCloudCover'].'/8
					</div>
					</div>
					<div class="infoInTable">
					<div>
					Sannolikhet för åska:
					</div>
					<div>
					'.$timeInterval['smhiProbThunder'].'/8
					</div>
					</div>
					';

			$tableRow .= '
			<tr>
				<td>
				'.$datecolumn. '
				</td>
				<td>
				Data saknas från YR
				</td>
				<td>'.
				$smhi
				.'</td>
			</tr>';
		}


		$forecastTable ='
		<div class ="row">
			<div class="col-md-6">
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
			<div class="col-md-6">
				<div id="map-canvas"></div>
			</div>
			</div>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$this->goolemapsKey.'"></script>
            <script src="Map.js"></script>
		';
		return $map;
	}

}