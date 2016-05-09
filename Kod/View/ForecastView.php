<?php
namespace View;

require_once('./Helpers/Settings.php');

class ForecastView{
	private $goolemapsKey;
	private $settings;

	public function __construct(){
		$this->settings = new \Settings\Settings();
		$this->goolemapsKey = $this->settings->getKey();
	}

	public function getGeonameId(){
		$citynameAndGeonameId = $_GET['forecast'];
		$explodedCitynameAndGeonameId = explode('~', $citynameAndGeonameId);
		$geonameId = $explodedCitynameAndGeonameId[1];
		return $geonameId;

	}

	public function getForecastHeader($city){
		$this->html='<h1>Väderprognos för <span class ="darkblueAsInHeader">'.$city.'</span>:</h1>';
		return $this->html;
	}

	public function getForecast(){
		$html ='
			<div class="col-md-8">
				<p>
					Här kommer prognosdata att visas!
				</p>
			</div>
		';
		return $html;
	}

	public function getMap(){
		$html='
			<div class="col-md-4">
				<div id="map-canvas"></div>
			</div>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$this->goolemapsKey.'"></script>
            <script src="Map.js"></script>
		';
		return $html;
	}

	public function getKey(){

	}

}