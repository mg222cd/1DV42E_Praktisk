<?php
namespace View;

class GeonamesView{
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
		$numberOfResults = $data['totalResultsCount'];
		return $numberOfResults;
	}
	
	public function hitList($geonamesList){
		$resultsrow='';
		foreach ($geonamesList as $geonames) {
			$resultsrow .= '<tr>
								<td>
								<a class="" href="?forecast='.$geonames->getName().'~'.$geonames->getGeonameId().'"</a>'
								 . $geonames->getName() . ', ' 
								 . $geonames->getAdminName2() .  ', '
								 . $geonames->getAdminName1() .  ', '
								 . $geonames->getCountryName() .
								 '
								 </td>
							<tr>';
		}
		$html= "
			<div id='geonamesTable' class='table-responsive'>
			<table class='table table-bordered table table-striped '>
				".$resultsrow."
			</table>
			</div>
		";
		return $html;
	}
}