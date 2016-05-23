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
			$name = $geonames->getName();
			$fcodeName = $geonames->getFcodeName();
			$adminName2 = $geonames->getAdminName2();
			$adminName1 = $geonames->getAdminName1();
			$country = $geonames->getCountryName();

			$resultsrow .= 
			'<tr>

				<td><a class="" href="?search='.$geonames->getName().'~'.$geonames->getGeonameId().'">'.$name.'</a></td>
				<td>'.$fcodeName.'</td>
				<td>'.$adminName2.'</td>
				<td>'.$adminName1.'</td>
				<td>'.$country.'</td>
			<tr>';

		}

		$html= '
			<div id="geonamesTable" class="table-responsive">
			<table class="table table-striped hitlist">
			<tr>
				<td>Ort</td>
				<td>Typ</td>
				<td>Kommun</td>
				<td>Område</td>
				<td>Land</td>
			'.$resultsrow.'
			</table>
			</div>
		';
		return $html;
	}

	public function cityFromListIsChoosen(){
		$url = $_GET['search'];
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
		$url = $_GET['search'];
		//Om den är tom
		if ($url == '') {
			return '';
		}
		//kolla om tilde finns:
		$containsTilde = strpos($url, '~');
		if ($containsTilde === false) {
			return '';
		}
		//kolla att något står efter tilde
		$explodedUrl = explode('~', $url);
		if ($containsTilde == 0) {
			return $explodedUrl[0];
		}
		$afterTilde = $explodedUrl[1];
		//Om inget finns efter tilde
		if ($afterTilde == '') {
			return '';
		}
		return $afterTilde;
	}
}