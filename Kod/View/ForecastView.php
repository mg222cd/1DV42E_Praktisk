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

	public function getForecast(){
		$html ='
			<div class="col-md8">
				<p>
					Här kommer prognosdata att visas!
				</p>
			</div>
		';
		return $html;
	}

	public function getMap(){
		$html='
			<div class="col-md4">
				<div id="map-canvas"></div>
			</div>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$this->goolemapsKey.'"></script>
            <script src="Map.js"></script>
            <script src="Message.js"></script>
		';
		return $html;
	}

	public function getKey(){

	}

}