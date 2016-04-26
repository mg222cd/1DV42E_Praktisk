<?php
namespace View;

class ForecastView{
	private $statusMessage;

	public function geonamesWebserviceErrorMessage(){
		$this->statusMessage = 
			'<p>
				Beklagar! Det verkar som om webservicen Geonames.org för tillfället ligger nere, varför sökning direkt
				mot Geonames ej kunde genomföras. Sökning har istället skett i vår egen databas, där de populäraste orterna 
				finns lagrade. Om din ort saknas i träfflistan ber vi dig att försöka igen lite senare.
			</p>';
		return $this->statusMessage;
	}

	public function noResultsFoundErrorMessage(){
		$this->statusMessage =
		'<p>
			Ingen ort hittades. Kontrollera stavningen och försök ingen.
		</p>';
		return $this->statusMessage;
	}

	public function numberOfResultsFromGeonames ($data){
		$dataDecoded = json_decode($data, true);
		$numberOfResults = $dataDecoded['totalResultsCount'];
		return $numberOfResults;
	}
	
}