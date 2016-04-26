<?php
namespace View;

class SearchView{
	private $errorMessage = '';
	private $html = '';
	private $givenCity;

	public function getCity(){
		if (isset($_POST['city']) && $_POST['city'] != '') {
			$this->givenCity = $_POST['city'];
			return $this->givenCity;
		}
		$this->errorMessage = '<p>Ingen ort har angivits. Försök igen.</p>';
		return NULL;
	}

	public function getErrorMessage(){
		return $this->errorMessage;
	}

	public function getCityHeader(){
		$this->html='<h1>Sökresultat för <span class ="darkblueAsInHeader">'.$this->givenCity.'</span>:</h1>';
		return $this->html;
	}

}