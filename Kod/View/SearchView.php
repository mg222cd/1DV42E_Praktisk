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
        'Guinea-Bissau' => 'Guinea-Bissau' //Bissau
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
        'Caymanöarna' => 'Cayman Islands' //George Town
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
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //
        '' => '', //


TM	TKM	795	TX	Turkmenistan	Ashgabat	488,100.0	4,940,916	AS
TN	TUN	788	TS	Tunisia	Tunis	163,610.0	10,589,025	AF
TO	TON	776	TN	Tonga	Nuku'alofa	748.0	122,580	OC
TR	TUR	792	TU	Turkey	Ankara	780,580.0	77,804,122	AS
TT	TTO	780	TD	Trinidad and Tobago	Port of Spain	5,128.0	1,228,691	NA
TV	TUV	798	TV	Tuvalu	Funafuti	26.0	10,472	OC
TW	TWN	158	TW	Taiwan	Taipei	35,980.0	22,894,384	AS
TZ	TZA	834	TZ	Tanzania	Dodoma	945,087.0	41,892,895	AF
UA	UKR	804	UP	Ukraine	Kiev	603,700.0	45,415,596	EU
UG	UGA	800	UG	Uganda	Kampala	236,040.0	33,398,682	AF
UM	UMI	581		U.S. Minor Outlying Islands		0.0	0	OC
US	USA	840	US	United States	Washington	9,629,091.0	310,232,863	NA
UY	URY	858	UY	Uruguay	Montevideo	176,220.0	3,477,000	SA
UZ	UZB	860	UZ	Uzbekistan	Tashkent	447,400.0	27,865,738	AS
VA	VAT	336	VT	Vatican City	Vatican City	0.4	921	EU
VC	VCT	670	VC	Saint Vincent and the Grenadines	Kingstown	389.0	104,217	NA
VE	VEN	862	VE	Venezuela	Caracas	912,050.0	27,223,228	SA
VG	VGB	092	VI	British Virgin Islands	Road Town	153.0	21,730	NA
VI	VIR	850	VQ	U.S. Virgin Islands	Charlotte Amalie	352.0	108,708	NA
VN	VNM	704	VM	Vietnam	Hanoi	329,560.0	89,571,130	AS
VU	VUT	548	NH	Vanuatu	Port Vila	12,200.0	221,552	OC
WF	WLF	876	WF	Wallis and Futuna	Mata Utu	274.0	16,025	OC
WS	WSM	882	WS	Samoa	Apia	2,944.0	192,001	OC
XK	XKX	0	KV	Kosovo	Pristina	10,908.0	1,800,000	EU
YE	YEM	887	YM	Yemen	Sanaa	527,970.0	23,495,361	AS
YT	MYT	175	MF	Mayotte	Mamoudzou	374.0	159,042	AF
ZA	ZAF	710	SF	South Africa	Pretoria	1,219,912.0	49,000,000	AF
ZM	ZMB	894	ZA	Zambia	Lusaka	752,614.0	13,460,305	AF
ZW	ZWE	716	ZI	Zimbabwe	Harare	390,580.0	13,061,000	AF


    ];

    return str_replace(array_keys($values), $values, $text);
}


}