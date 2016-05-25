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
        '' => '', //
        '' => '', //
        '' => '', //

PK	PAK	586	PK	Pakistan	Islamabad	803,940.0	184,404,791	AS
PL	POL	616	PL	Poland	Warsaw	312,685.0	38,500,000	EU
PM	SPM	666	SB	Saint Pierre and Miquelon	Saint-Pierre	242.0	7,012	NA
PN	PCN	612	PC	Pitcairn Islands	Adamstown	47.0	46	OC
PR	PRI	630	RQ	Puerto Rico	San Juan	9,104.0	3,916,632	NA
PS	PSE	275	WE	Palestine	East Jerusalem	5,970.0	3,800,000	AS
PT	PRT	620	PO	Portugal	Lisbon	92,391.0	10,676,000	EU
PW	PLW	585	PS	Palau	Melekeok	458.0	19,907	OC
PY	PRY	600	PA	Paraguay	Asuncion	406,750.0	6,375,830	SA
QA	QAT	634	QA	Qatar	Doha	11,437.0	840,926	AS
RE	REU	638	RE	Réunion	Saint-Denis	2,517.0	776,948	AF
RO	ROU	642	RO	Romania	Bucharest	237,500.0	21,959,278	EU
RS	SRB	688	RI	Serbia	Belgrade	88,361.0	7,344,847	EU
RU	RUS	643	RS	Russia	Moscow	17,100,000.0	140,702,000	EU
RW	RWA	646	RW	Rwanda	Kigali	26,338.0	11,055,976	AF
SA	SAU	682	SA	Saudi Arabia	Riyadh	1,960,582.0	25,731,776	AS
SB	SLB	090	BP	Solomon Islands	Honiara	28,450.0	559,198	OC
SC	SYC	690	SE	Seychelles	Victoria	455.0	88,340	AF
SD	SDN	729	SU	Sudan	Khartoum	1,861,484.0	35,000,000	AF
SE	SWE	752	SW	Sweden	Stockholm	449,964.0	9,828,655	EU
SG	SGP	702	SN	Singapore	Singapore	692.7	4,701,069	AS
SH	SHN	654	SH	Saint Helena	Jamestown	410.0	7,460	AF
SI	SVN	705	SI	Slovenia	Ljubljana	20,273.0	2,007,000	EU
SJ	SJM	744	SV	Svalbard and Jan Mayen	Longyearbyen	62,049.0	2,550	EU
SK	SVK	703	LO	Slovakia	Bratislava	48,845.0	5,455,000	EU
SL	SLE	694	SL	Sierra Leone	Freetown	71,740.0	5,245,695	AF
SM	SMR	674	SM	San Marino	San Marino	61.2	31,477	EU
SN	SEN	686	SG	Senegal	Dakar	196,190.0	12,323,252	AF
SO	SOM	706	SO	Somalia	Mogadishu	637,657.0	10,112,453	AF
SR	SUR	740	NS	Suriname	Paramaribo	163,270.0	492,829	SA
SS	SSD	728	OD	South Sudan	Juba	644,329.0	8,260,490	AF
ST	STP	678	TP	São Tomé and Príncipe	Sao Tome	1,001.0	175,808	AF
SV	SLV	222	ES	El Salvador	San Salvador	21,040.0	6,052,064	NA
SX	SXM	534	NN	Sint Maarten	Philipsburg	21.0	37,429	NA
SY	SYR	760	SY	Syria	Damascus	185,180.0	22,198,110	AS
SZ	SWZ	748	WZ	Swaziland	Mbabane	17,363.0	1,354,051	AF
TC	TCA	796	TK	Turks and Caicos Islands	Cockburn Town	430.0	20,556	NA
TD	TCD	148	CD	Chad	N'Djamena	1,284,000.0	10,543,464	AF
TF	ATF	260	FS	French Southern Territories	Port-aux-Francais	7,829.0	140	AN
TG	TGO	768	TO	Togo	Lome	56,785.0	6,587,239	AF
TH	THA	764	TH	Thailand	Bangkok	514,000.0	67,089,500	AS
TJ	TJK	762	TI	Tajikistan	Dushanbe	143,100.0	7,487,489	AS
TK	TKL	772	TL	Tokelau		10.0	1,466	OC
TL	TLS	626	TT	East Timor	Dili	15,007.0	1,154,625	OC
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