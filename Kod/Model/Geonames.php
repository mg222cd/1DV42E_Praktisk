<?php
namespace Model;

class Geonames{
	private $geonamesPk;
	private $geonameId;
	private $name;
	private $adminName1;
	private $adminName2;
	private $countryName
	private $lat;
	private $lang;

	public function __construct($geonamesPk, $geonameId, $name, $adminName1, $adminName2, $countryName, $lat, $lang){
		$this->geonamesPk = $geonamesPk;
		$this->geonameId = $geonameId;
		$this->name = $name;
		$this->adminName1 = $adminName1;
		$this->adminName2 = $adminName2;
		$this->countryName = $countryName;
		$this->lat = $lat;
		$this->lang = $lang;
	}
}