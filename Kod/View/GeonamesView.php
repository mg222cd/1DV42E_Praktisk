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

	public function getNumberOfHitsHeader($numberOfHits){
		$this->statusMessage =
		'<p>
			Antal träffar: '.$numberOfHits.'
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
			<tr>
			'.$resultsrow.'
			</table>
			</div>
		';
		return $html;
	}

	public function refinedSearchField(){
		$refinedSearchForm='
		<div class="row">
		<div class="col-md-12">     
            <form class="form-inline" method="get" role="form" action="?'.NavigationView::$actionSearch.'">
                <div class="form-group">
                    <input type="text" class="form-control" maxlength="255" name="city" id="city" placeholder="Sök väder via ort" autofocus="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" maxlength="255" name="adminName2" id="adminName2" placeholder="Sök väder via ort" autofocus="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" maxlength="255" name="adminName1" id="adminName1" placeholder="Sök väder via ort" autofocus="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" maxlength="255" name="country" id="country" placeholder="Sök väder via ort" autofocus="">
                </div>
                <div class="form-group">
                    <input type="submit" value="Sök" class="btn btn-default">
                </div>
        	</form>
        </div>
        </div>';
        return $refinedSearchForm;
	}

	/*
	public function paginatedHitList($geonamesObject, $numberOfHits){
		// page is the current page, if there's nothing set, default is page 1
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		// set records or rows of data per page
		$recordsPerPage = 10;
		// calculate for the query LIMIT clause
		$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;
		//this is how to get number of rows returned
		$num = $numberOfHits; 
		//check if more than 0 record found
		if($num>0){
		    //start table
		    $html= '
			<div id="geonamesTable" class="table-responsive">
				<table class="table table-striped hitlist">
				<tr>
					<td>Ort</td>
					<td>Typ</td>
					<td>Kommun</td>
					<td>Område</td>
					<td>Land</td>
				<tr>
			';
			foreach ($geonamesObject as $row) {
				//extract row, this will make $row['firstname'] to just $firstname only
		        //extract($row);
		        //creating new table row per record
		        $html .=

				'<tr>
					<td><a class="" href="?search='.$row->getName().'~'.$row->getGeonameId().'">'.$row->getName().'</a></td>
					<td>'.$row->getFcodeName().'</td>
					<td>'.$row->getAdminName2().'</td>
					<td>'.$row->getAdminName2().'</td>
					<td>'.$row->getCountryName().'</td>
				<tr>';
			}
		         
		    $html .=  '</table></div>';//end table
		    // ***** Paging section will be here ***** 
		}
		return $html;
	}
	*/

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