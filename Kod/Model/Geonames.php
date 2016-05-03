<?php
namespace Model;

class Geonames{
	private $geonamesPk;
	private $geonameId;
	private $name;
	private $adminName1;
	private $adminName2;
	private $countryName;
	private $fcodeName;
	private $lat;
	private $lng;

	public function __construct($geonamesPk, $geonameId, $name, $adminName1, $adminName2, $countryName, $fcodeName, $lat, $lang){
		$this->geonamesPk = $geonamesPk;
		$this->geonameId = $geonameId;
		$this->name = $name;
		$this->adminName1 = $adminName1;
		$this->adminName2 = $adminName2;
		$this->countryName = $countryName;
		$this->fcodeName = $fcodeName;
		$this->lat = $lat;
		$this->lng = $lang;
	}

	public function getGeonamesPk(){
		return $this->geonamesPk;
	}

	public function getGeonameId(){
		return $this->geonameId;
	}

	public function getName(){
		return $this->name;
	}

	public function getAdminName1(){
		return $this->adminName1;
	}

	public function getAdminName2(){
		return $this->adminName2;
	}

	public function getCountryName(){
		return $this->countryName;
	}

	public function getFcodeName(){
		return $this->fcodeName;
	}

	public function getLat(){
		return $this->lat;
	}

	public function getLng(){
		return $this->lng;
	}
}