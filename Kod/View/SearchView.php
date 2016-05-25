<?php
namespace View;

class SearchView{
	private $errorMessage = '';
	private $html = '';
	private $givenCity;
	private $postedCity;
	private $postedAdminName;
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
		$this->html='<h1>Sökresultat för <span class ="darkblueAsInHeader">'.$city.'</span></h1>';
		return $this->html;
	}

	public function getRefinedHeader($postedCity, $postedAdminName, $postedCountry){
		$this->html='<h1>Sökresultat för <span class ="darkblueAsInHeader">'
		.$postedCity.' '.$postedAdminName. ' '.$postedCountry. '</span></h1>';
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

	public function getPostedAdminName(){
		if (isset($_POST['adminName']) && $_POST['adminName'] != '') {
			$this->postedAdminName = $_POST['adminName'];
			return $this->postedAdminName;
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

	public function getTranslation($text)
{
    $values = [
        'Sverige' => 'Sweden',
        'Afganistan' => 'Afghanistan'
        	Asia
Albania	Europe
Algeria	Africa
American Samoa	Australasia
Andorra	Europe
Angola	Africa
Anguilla	Caribbean
Antigua and Barbuda	Caribbean
Argentina	South America
Armenia	Europe
Aruba	Caribbean
Australia	Australasia
Austria	Europe
Azerbaijan	Europe
Bahamas	Caribbean
Bahrain	Middle East
Bangladesh	Asia
Barbados	Caribbean
Belarus	Europe
Belgium	Europe
Belize	North America
Benin	Africa
Bermuda	Caribbean
Bhutan	Asia
Bolivia	South America
Bonaire	Caribbean
Bosnia-Herzegovina	Europe
Botswana	Africa
Bouvet Island	Africa
Brazil	South America
Brunei	Asia
Bulgaria	Europe
Burkina Faso	Africa
Burundi	Africa
Cambodia	Asia
Cameroon	Africa
Canada	North America
Cape Verde	Africa
Cayman Islands	Caribbean
Central African Republic	Africa
Chad	Africa
Chile	South America
China	Asia
Christmas Island	Australasia
Cocos (Keeling) Islands	Australasia
Colombia	South America
Comoros	Africa
Congo, Democratic Republic of the (Zaire)	Africa
Congo, Republic of	Africa
Cook Islands	Australasia
Costa Rica	North America
Croatia	Europe
Cuba	Caribbean
Curacao	Caribbean
Cyprus	Europe
Czech Republic	Europe
Denmark	Europe
Djibouti	Africa
Dominica	Caribbean
Dominican Republic	Caribbean
Ecuador	South America
Egypt	Africa
El Salvador	North America
Equatorial Guinea	Africa
Eritrea	Africa
Estonia	Europe
Ethiopia	Africa
Falkland Islands	South America
Faroe Islands	Europe
Fiji	Australasia
Finland	Europe
France	Europe
French Guiana	South America
Gabon	Africa
Gambia	Africa
Georgia	Europe
Germany	Europe
Ghana	Africa
Gibraltar	Europe
Greece	Europe
Greenland	Europe
Grenada	Caribbean
Guadeloupe (French)	Caribbean
Guam (USA)	Australasia
Guatemala	North America
Guinea	Africa
Guinea Bissau	Africa
Guyana	South America
Haiti	Caribbean
Holy See	Europe
Honduras	North America
Hong Kong	Asia
Hungary	Europe
Iceland	Europe
India	Asia
Indonesia	Asia
Iran	Middle East
Iraq	Middle East
Ireland	Europe
Israel	Middle East
Italy	Europe
Ivory Coast (Cote D`Ivoire)	Africa
Jamaica	Caribbean
Japan	Asia
Jordan	Middle East
Kazakhstan	Asia
Kenya	Africa
Kiribati	Australasia
Kosovo	Europe
Kuwait	Middle East
Kyrgyzstan	Asia
Laos	Asia
Latvia	Europe
Lebanon	Middle East
Lesotho	Africa
Liberia	Africa
Libya	Africa
Liechtenstein	Europe
Lithuania	Europe
Luxembourg	Europe
Macau	Asia
Macedonia	Europe
Madagascar	Africa
Malawi	Africa
Malaysia	Asia
Maldives	Asia
Mali	Africa
Malta	Europe
Marshall Islands	Australasia
Martinique (French)	Caribbean
Mauritania	Africa
Mauritius	Africa
Mayotte	Africa
Mexico	North America
Micronesia	Australasia
Moldova	Europe
Monaco	Europe
Mongolia	Asia
Montenegro	Europe
Montserrat	Caribbean
Morocco	Africa
Mozambique	Africa
Myanmar	Asia
Namibia	Africa
Nauru	Australasia
Nepal	Asia
Netherlands	Europe
Netherlands Antilles	Caribbean
New Caledonia (French)	Australasia
New Zealand	Australasia
Nicaragua	North America
Niger	Africa
Nigeria	Africa
Niue	Australasia
Norfolk Island	Australasia
North Korea	Asia
Northern Mariana Islands	Asia
Norway	Europe
Oman	Middle East
Pakistan	Asia
Palau	Australasia
Panama	North America
Papua New Guinea	Australasia
Paraguay	South America
Peru	South America
Philippines	Asia
Pitcairn Island	Australasia
Poland	Europe
Polynesia (French)	Australasia
Portugal	Europe
Puerto Rico	Caribbean
Qatar	Middle East
Reunion	Africa
Romania	Europe
Russia	Europe
Rwanda	Africa
Saint Helena	Africa
Saint Kitts and Nevis	Caribbean
Saint Lucia	Caribbean
Saint Pierre and Miquelon	North America
Saint Vincent and Grenadines	Caribbean
Samoa	Australasia
San Marino	Europe
Sao Tome and Principe	Africa
Saudi Arabia	Middle East
Senegal	Africa
Serbia	Europe
Seychelles	Africa
Sierra Leone	Africa
Singapore	Asia
Sint Maarten	Caribbean
Slovakia	Europe
Slovenia	Europe
Solomon Islands	Australasia
Somalia	Africa
South Africa	Africa
South Georgia and South Sandwich Islands	South America
South Korea	Asia
South Sudan	Africa
South Sudan	Africa
Spain	Europe
Sri Lanka	Asia
Sudan	Africa
Suriname	South America
Svalbard and Jan Mayen Islands	Europe
Swaziland	Africa
Sweden	Europe
Switzerland	Europe
Syria	Middle East
Taiwan	Asia
Tajikistan	Asia
Tanzania	Africa
Thailand	Asia
Timor-Leste (East Timor)	Australasia
Togo	Africa
Tokelau	Australasia
Tonga	Australasia
Trinidad and Tobago	Caribbean
Tunisia	Africa
Turkey	Middle East
Turkmenistan	Asia
Turks and Caicos Islands	Caribbean
Tuvalu	Australasia
Uganda	Africa
Ukraine	Europe
United Arab Emirates	Middle East
United Kingdom	Europe
United States	North America
Uruguay	South America
Uzbekistan	Asia
Vanuatu	Australasia
Venezuela	South America
Vietnam	Asia
Virgin Islands	Caribbean
Wallis and Futuna Islands	Australasia
Yemen	Middle East
Zambia	Africa
Zimbabwe	Africa
xk	Europe

    ];

    return str_replace(array_keys($values), $values, $text);
}


}