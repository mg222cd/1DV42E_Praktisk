<?php
namespace Model;

require_once('./Model/Geonames.php');

class GeonamesModel{
	private $city;
	private $geonamesList = array();


	public function geonamesRequest($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept' => 'application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	public function testGeonames(){
		$testUrlString = 'http://api.geonames.org/searchJSON?name=Bruksvallarna&style=full&maxRows=100&username=marikegrinde';
		$testData = $this->geonamesRequest($testUrlString);
		if ($testData == false) {
			return false;
		}
		return true;
	}

	public function getGeonames($city){
		//mellanslags-fix
		$cityWithoutSpaces = preg_replace('/\s+/', '%20', $city);
		$urlRequestGeonames = 'http://api.geonames.org/searchJSON?name_equals='.$cityWithoutSpaces.'&style=full&maxRows=100&username=marikegrinde';
		$data = $this->geonamesRequest($urlRequestGeonames);
		$dataDecoded = json_decode($data, true);
		return $dataDecoded;
	}

	public function getGeonamesRefined($postedCity, $postedAdminName, $postedCountry){
		if ($postedCountry != NULL) {
			$postedCountry = $this->getTranslation($postedCountry);
		}
		//http://api.geonames.org/searchJSON?name_equals=Flon&q=J%C3%A4mtland&q=sweden&style=full&maxRows=100&username=marikegrinde
		$url = 'http://api.geonames.org/searchJSON?';
		if ($postedCity != null) {
			$cityWithoutSpaces = preg_replace('/\s+/', '%20', $postedCity);
			$url .= '&name_equals='.$cityWithoutSpaces;
		}
		if ($postedAdminName != null) {
			$adminWithoutSpaces = preg_replace('/\s+/', '%20', $postedAdminName);
			$url .= '&q='.$adminWithoutSpaces;
		}
		if ($postedCountry != null) {
			$countryWithoutSpaces = preg_replace('/\s+/', '%20', $postedCountry);
			$url .= '&q='.$countryWithoutSpaces;
		}
		$url .= '&style=full&maxRows=100&username=marikegrinde';
		$data = $this->geonamesRequest($url);
		$dataDecoded = json_decode($data, true);
		return $dataDecoded;
	}

	public function getCityByGeonameId($geonameIdSanitized){
		$url = 'http://api.geonames.org/get?geonameId='.$geonameIdSanitized.'&username=marikegrinde&style=full';
		//$url = 'http://api.geonames.org/get?geonameId=980dssjhd0as0s0u&username=marikegrinde&style=full';
		$data = $this->geonamesRequest($url);
		$status = strpos($data, $geonameIdSanitized);
		if ($status === false) {
			return false;
		}
		$dataDecoded = new \SimpleXMLElement($data);
		$geonamesObj = new \model\Geonames(
			null, //GeonamesPk 
			$dataDecoded->geonameId, 
			$dataDecoded->name, 
			$dataDecoded->adminName1, 
			$dataDecoded->adminName2, 
			$dataDecoded->countryName,
			$dataDecoded->fcodeName,
			$dataDecoded->lat,
			$dataDecoded->lng);
		return $geonamesObj;
	}

	//Filtrates oyt html and tags
	public function sanitizeText($city){
		$sanitizedText = strip_tags($city);
		$trimmedText = trim($sanitizedText);
		if ($trimmedText != $city) {
			return $trimmedText;
		}
		return $city;
	}

	public function getGeonamesObject($geonamesArr){
		unset($this->geonamesList);
		$this->geonamesList = array();

		foreach ($geonamesArr['geonames'] as $geoname) {
			$geonames = new \model\Geonames(
			null, //GeonamesPk 
			$geoname['geonameId'], 
			$geoname['name'], 
			$geoname['adminName1'], 
			$geoname['adminName2'], 
			$geoname['countryName'],
			$geoname['fcodeName'],
			$geoname['lat'],
			$geoname['lng']);
			$this->geonamesList [] = $geonames;
		}
		return $this->geonamesList;
	}

	public function parseCoordinate($coordinate){
		$newCoordinate = (string) $coordinate;
		return $newCoordinate;
	}

		public function getTranslation($text){
    $values = [
        'Afganistan' => 'Afghanistan', //Kabul                            
        'Albanien' => 	'Albania', //Tirana                               
        'Algeriet' => 'Algeria', //Alger
        'American Samoa' => 'Amerikanska Samoa', //Pago Pago              
        'Andorra' => 'Andorra', //Andorra l Vella 				          
        'Angola' => 'Angola', //Luanda                                    
		'Anguilla' => 'Anguilla', //The Valley                            
		'Antarktis' => 'Antarctica', //-                                  
        'Antigua och Barbuda' => 'Antigua and Barbuda', //Saint John's    
        'Argentina' => 'Argentina', //Buenos Aires                        
        'Armenien' => 'Armenia', // Jerevan                               
        'Aruba' => 'Aruba', //Oranjestad                                  
        'Australien' => 'Australia', //Canberra                           
        'Åland' => 'Åland', //Mariehamn                                   
        'Österrike' => 'Austria', //Wien                                  
        'Azerbajdzjan' => 'Azerbaijan', //Baku                            
        'Bahamas' => 'Bahamas', //Nassau                                  
        'Bahrain' => 'Bahrain', //Manama                                  
        'Bangladesh' => 'Bangladesh', //Dkaka                             
        'Barbados' => 'Barbados', //Bridgetown                            
        'Vitryssland' =>'Belarus', //Minsk                                
        'Belgien' => 'Belgium', //Bryssel                                 
        'Belize' => 'Belize', //Belmopan                                  
        'Benin' => 'Benin', //Porto-Novo                                  
        'Bermuda' => 'Bermuda', //Hamilton                                
        'Bhutan' => 'Bhutan', //Thimphu                                   
        'Bolivia' => 'Bolivia', //Sucre                                   
        'Bonaire' => 'Bonaire', //-                                       
        'Bosnien och Hercegovina' => '', //Sarajevo                       
        'Botswana' => 'Botswana', //Gaborone?                             
        'Förenade Arabemiraten' => 'United Arab Emirates', //Abu Dhabi    
        'Burkina Faso' => 'Burkina Faso', //Ouagadougou
        'Bulgarien' => 'Bulgaria', //Sofia
        'Burundi' => 'Burundi', //Bujumbura
        'Saint-Barthélemy' => 'Saint-Barthélemy', //Gustavia
        'Brunei' => 'Brunei', //Bandar Seri Bagawan
        'Brasilien' => 'Brazil', //Brasilia
        'Bouvetön' => 'Bouvet Island', //-
        'Kanada' => 'Canada', //Ottawa
        'Kokosöarna' => 'Cocos [Keeling] Islands', //West Island
        'Kongo-Kinshasa' => 'Democratic Republic of the Congo', //Kinshasa
        'Centralafrikanska republiken' => 'Central African Republic', //Bangui
        'Kongo-Brazzaville' => 'Republic of this Congo', //Brazzaville
        'Schweiz' => 'Switzerland', //Bern
        'Elfenbenskusten' => 'Ivory Coast', //Yamoussoukro
        'Cooköarna' => 'Cook Islands', //Avarua
        'Chile' => 'Chile', //Santiago
        'Kamerun' => 'Cameroon', //Yaounde
        'Kina' => 'China', //Beijing
        'Colombia' => 'Colombia', //Bogota
        'Costa Rica' => 'Costa Rica', //San Jose
        'Kuba' => 'Cuba', //Havanna
        'Kap Verde' => 'Cape Verde', //Praia
        'Curacao' => 'Curacao', //Willemstad
        'Julön' => 'Christmas Island', //Flying Fish Cove
        'Cypern' => 'Cyprus', //Nicosia
        'Tjeckien' => 'Czech Republic', //Prag
        'Tyskland' => 'Germany', //Berlin
        'Djibouti' => 'Djibouti', //Djibouti
        'Danmark' => 'Denmark', //Köpenhamn
        'Dominica' => 'Dominica', //
        'Dominikanska republiken' => 'Dominican Republic', //Roseau
        'Equador' => 'Ecuador', //Quito
        'Estland' => 'Estonia', //Tallinn
        'Egypten' => 'Egypt', //Kairo
        'Västsahara' => 'Western Sahara', //?
        'Eritrea' => 'Eritrea', //Asmara
        'Spanien' => 'Spain', //Madrid
        'Etiopien' => 'Ethiopia', //Addis Abeba?
        'Finland' => 'Finland', //Helsingfors
        'Fiji' => 'Fiji', //Suva
        'Falklandsöarna' => 'Falkland Islands', //Stanley
        'Mikronesien' => 'Micronesia', //Palikir
        'Färöarna' => 'Faroe Islands', //Torshavn
        'Frankrike' => 'France', //Paris
        'Gabon' => 'Gabon', //Libreville
        'Storbritanien' => 'United Kingdom', //London
        'Grenada' => 'Grenada', //St. George's
        'Georgien' => 'Georgia', //Tbilisi
        'Franska Guyana' => 'French Guiana', //Cayenne
        'Guernsey' => 'Guernsey', //St Peter Port
        'Ghana' => 'Ghana', //Accra
        'Gibraltar' => 'Gibraltar', //Gibraltar
        'Grönland' => 'Greenland', //Nuuk
        'Gambia' => 'Gambia', //Banjul
        'Guinea' => 'Guinea', //Conakry
        'Guadeloupe' => 'Guadeloupe', //Basse-Terre
        'Ekvatorialguinea' => 'Equatorial Guinea', //Malabo
        'Grekland' => 'Greece', //Aten
        'Sydgeorgien och Sydsandwichöarna' => 'South Georgia and the South Sandwich Islands', //Grytviken
        'Guatemala' => 'Guatemala', //Guatemala City
        'Guam' => 'Guam', //Hagatna
        'Guinea-Bissau' => 'Guinea-Bissau', //Bissau
        'Guyana' => 'Guyana', //Georgetown
        'Hong Kong' => 'Hong Kong', //Hong Kong
        'Heard- och McDonaldöarna' => 'Heard Island and McDonald Islands', //-
        'Honduras' => 'Honduras', //Tegucigalpa
        'Kroatien' => 'Croatia', //Zagreb
        'Haiti' => 'Haiti', //Port-au-Prince
        'Ungern' => 'Hungary', //Budapest
        'Indonesien' => 'Indonesia', //Jakarta
        'Irland' => 'Ireland', //Dublin
        'Israel' => 'Israel', //Jerusalem
        'Isle of Man' => 'Isle of Man', //Douglas
        'Indien' => 'India', //New Dehli
        'Brittiska territoriet i Indiska oceanen' => 'British Indian Ocean Territory', //Diego Garcia
        'Irak' => 'Iraq', //Baghdad
        'Iran' => 'Iran', //Teheran
        'Island' => 'Iceland', //Reyjkjavik
        'Italien' => 'Italy', //Rom
        'Jersey' => 'Jersey', //Saint Helier
        'Jamaica' => 'Jamaica', //Kingston
        'Jordanien' => 'Jordan', //Amman
        'Japan' => 'Japan', //Tokyo
        'Kenya' => 'Kenya', //Nairobi
        'Kirgizistan' => 'Kyrgyzstan', //Bisjkek
        'Kambodja' => 'Cambodia', //Phnom Penh
        'Kiribati' => 'Kiribati', //Tarawa
        'Komorerna' => 'Comoros', //Moroni
        'Saint Kitts och Nevis' => 'Saint Kitts and Nevis', //Basseterre
        'Nordkorea' => 'North Korea', //Pyongyang
        'Sydkorea' => 'South Korea', //Seoul
        'Kuwait' => 'Kuwait', //Kuwait
        'Kazakstan' => 'Kazakhstan', //Astana
        'Caymanöarna' => 'Cayman Islands', //George Town
        'Laos' => 'Laos', //Vientaine
        'Libanon' => 'Lebanon', //Beirut
        'Saint Lucia' => 'Saint Lucia', //Castries
        'Liechtenstein' => 'Liechtenstein', //Vaduz
        'Sri Lanka' => 'Sri Lanka', //Colombo
        'Liberia' => 'Liberia', //Monrovia
        'Lesotho' => 'Lesotho', //Maseru
        'Litauen' => 'Lithuania', //Vilnius
        'Luxemburg' => 'Luxembourg', //Luxemburg
        'Lettland' => 'Latvia', //Riga
        'Libyen' => 'Libya', //Tripoli
        'Marocko' => 'Morocco', //Rabat
        'Monaco' => 'Monaco', //Monaco
        'Moldavien' => 'Moldova', //Chisinau
        'Montenegro' => 'Montenegro', //Podgorica
        'Saint Martin' => 'Saint Martin', //Marigot
        'Madagaskar' => 'Madagascar', //Antananarivo
        'Marshallöarna' => 'Marshall Islands', //Majuro
        'Makedonien' => 'Macedonia', //Skopje
        'Mali' => 'Mali', //Bamako
        'Burma' => 'Myanmar [Burma]', //Naypyidaw
        'Mongoliet' => 'Mongolia', //Ulan Bator
        'Macao' => 'Macao', //Macao
        'Marianerna' => 'Northern Mariana Islands', //Saipan
        'Martinique' => 'Martinique', //Fort-de-France
        'Mauretanien' => 'Mauritania', //Nouakchott
        'Montserrat' => 'Montserrat', //Plymouth
        'Malta' => 'Malta', //Valetta
        'Mauritius' => 'Mauritius', //Port Louis
        'Maldiverna' => '', //Male
        'Malawi' => 'Malawi', //Lilongwe
        'Mexiko' => 'Mexico', //Mexico City
        'Malaysia' => 'Malaysia', //Kuala Lumpur
        'Mocambique' => 'Mozambique', //Maputo
        'Namibia' => 'Namibia', //Windhoek
        'Nya Kaledonien' => 'New Caledonia', //Noumea
        'Niger' => '', //Niamey
        'Norfolkön' => 'Norfolk Island', //Kingston
        'Nigeria' => 'Nigeria', //Abuja
        'Nicaragua' => 'Nicaragua', //Managua
        'Nederländerna' => 'Netherlands', //Amsterdam
        'Holland' => 'Netherlands', //Amsterdam
        'Norge' => 'Norway', //Oslo
        'Nepal' => 'Nepal', //Katmandu
        'Nauru' => 'Nauru', //Yaren
        'Niue' => 'Niue', //Alofi
        'Nya Zeeland' => 'New Zealand', //Wellington
        'Oman' => 'Oman', //Muskat
        'Panama' => 'Panama', //Panama City
        'Peru' => 'Peru', //Lima
        'Franska Polynesien' => 'French Polynesia', //Papeete
        'Papua Nya Guinea' => 'Papua New Guinea', //Port Moresby
        'Filippinerna' => 'Philippines', //Manila
        'Pakistan' => 'Pakistan', //Islamabad
        'Polen' => 'Poland', //Warszawa
        'Saint-Pierre och Miquelon' => 'Saint Pierre and Miquelon', //Saint-Pierre
        'Pitcairnöarna' => 'Pitcairn Islands', //Adamstown
        'Puerto Rico' => 'Puerto Rico', //San Juan
        'Palestina' => 'Palestine', //Östjerusalem
        'Portugal' => 'Portugal', //Lissabon
        'Palau' => 'Palau', //Melekeok
        'Paraguay' => 'Paraguay', //Asunción
        'Qatar' => 'Qatar', //Doha
        'Réunion' => 'Réunion', //Saint-Denis
        'Rumänien' => 'Romania', //Bukarest
        'Serbien' => 'Serbia', //Belgrad
        'Ryssland' => 'Russia', //Moskva
        'Rwanda' => 'Rwanda', //Kigali
        'Saudiarabien' => 'Saudi Arabia', //Riyadh
        'Salomonöarna' => 'Solomon Islands', //Honiara
        'Seychellerna' => 'Seychelles', //Victoria
        'Sudan' => 'Sudan', //Khartoum
        'Sverige' => 'Sweden', //Stockholm
        'Singapore' => 'Singapore', //Singapore
        'Sankta Helena' => 'Saint Helena', //Jamestown
        'Slovenien' => 'Slovenia', //Ljubljana
        'Svalbard' => 'Svalbard and Jan Mayen', //Longyearbyen
        'Slovakien' => 'Slovakia', //Bratislava
        'Sierra Leone' => 'Sierra Leone', //Freetown
        'San Marino' => 'San Marino', //San Marino
        'Senegal' => 'Senegal', //Dakar
        'Somalia' => 'Somalia', //Mogadishu
        'Surinam' => 'Suriname', //Paramaribo
        'Sydsudan' => 'South Sudan', //Juba
        'Sao Tome och Principe' => 'São Tomé and Príncipe', //Sao Tome
        'El Salvador' => 'El Salvador', //San Salvador
        'Sint Maarten' => 'Sint Maarten', //Philipsburg
        'Syrien' => 'Syria', //Damaskus
        'Swaziland' => 'Swaziland', //Mbabane
        'Turks- och Caicosöarna' => 'Turks and Caicos Islands', //Cockburn Town
        'Tchad' => 'Chad', //N'Djamena
        'Franska sydterritorierna' => 'French Southern Territories', //Port-aux-Francais
        'Togo' => 'Togo', //Lome
        'Thailand' => 'Thailand', //Bangkok
        'Tadzjikistan' => 'Tajikistan', //Dusjanbe
        'Tokelau' => 'Tokelau', //-
        'Östtimor' => 'East Timor', //Dili
        'Turkmenistan' => 'Turkmenistan', //Ashgabat
        'Tunisien' => 'Tunisia', //Tunis
        'Tonga' => 'Tonga', //Nuku'alofa
        'Turkiet' => 'Turkey', //Ankara
        'Trinidad och Tobago' => 'Trinidad and Tobago', //Port of Spain
        'Tuvalu' => 'Tuvalu', //Funafuti
        'Taiwan' => 'Taiwan', //Taipei
        'Tanzania' => 'Tanzania', //Dodoma
        'Ukraina' => 'Ukraine', //Kiev
        'Uganda' => 'Uganda', //Kampala
        'Förenta staternas mindre öar i Oceanien och Västindien' => 'U.S. Minor Outlying Islands', //-
        'USA' => 'United States', //Washington
        'Uruguay' => 'Uruguay', //Montevideo
        'Uzbekistan' => 'Uzbekistan', //Tashkent
        'Vatikanstaten' => 'Vatican City', //Vatican City
        'Saint Vincent och Grenadinerna' => 'Saint Vincent and the Grenadines', //Kingstown
        'Venezuela' => 'Venezuela', //Caracas
        'Brittiska Jungfruöarna' => 'British Virgin Islands', //Road Town
        'Amerikanska Jungfruöarna' => 'U.S. Virgin Islands', //Charlotte Amalie
        'Vietnam' => 'Vietnam', //Hanoi
        'Vanuatu' => 'Vanuatu', //Port Vila
        'Wallis- och Futunaöarna' => 'Wallis and Futuna', //Mata Utu
        'Samoa' => 'Samoa', //Apia
        'Kosovo' => 'Kosovo', //Pristina
        'Jemen' => 'Yemen', //Sanaa
        'Mayotte' => 'Mayotte', //Mamoudzou
        'Sydafrika' => 'South Africa', //Pretoria
        'Zambia' => 'Zambia', //Lusaka
        'Zimbabwe' => 'Zimbabwe', //Harare
    ];
    return str_replace(array_keys($values), $values, $text);
}

}