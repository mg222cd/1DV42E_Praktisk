<?php
namespace View;

class SearchView{
	private $errorMessage = '';
	private $html = '';
	private $givenCity;
	private $postedCity;
	private $postedAdminName1;
	private $postedAdminName2;
	private $postedCountry;

	public function getCity(){
		if (isset($_GET['search']) && $_GET['search'] != '') {
			$this->givenCity = $_GET['search'];
			return $this->givenCity;
		}
		$this->errorMessage = '<p>Ingen ort har angivits. Försök igen.</p>';
		return null;
	}

	public function getErrorMessage(){
		return $this->errorMessage;
	}

	public function getCityHeader($city){
		$this->html='<h1>Sökresultat för <span class ="darkblueAsInHeader">'.$city.'</span>:</h1>';
		return $this->html;
	}

	public function getRefinedSearch(){
		if (isset($_POST['city']) && $_POST['city'] != '' ||
			isset($_POST['adminName2']) && $_POST['adminName2'] != '' ||
			isset($_POST['adminName1']) && $_POST['adminName1'] != '' ||
			isset($_POST['country']) && $_POST['country'] != '') {
			return true;
		}
		return false;
	}

	public function getPostedCity(){
		if (isset($_POST['city']) && $_POST['city'] != '') {
			$this->postedCity = $_POST['city'];
			return $this->postedCity;
		}
		return null;
	}

	public function getPostedAdminName1(){
		if (isset($_POST['adminName1']) && $_POST['adminName1'] != '') {
			$this->postedAdminName1 = $_POST['adminName1'];
			return $this->postedAdminName1;
		}
		return null;
	}

	public function getPostedAdminName2(){
		if (isset($_POST['adminName2']) && $_POST['adminName2'] != '') {
			$this->postedAdminName2 = $_POST['adminName2'];
			return $this->postedAdminName2;
		}
		return null;
	}

	public function getPostedCountry(){
		if (isset($_POST['country']) && $_POST['country'] != '') {
			$this->postedCountry = $_POST['country'];
			return $this->postedCountry;
		}
		return null;
	}

}