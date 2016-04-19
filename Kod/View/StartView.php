<?php
namespace View;

class StartView{
	private $message = 'Ett testmeddelande i startvyn. Om inget annat action är ifyllt är det detta som visas, och det är tänkt att vara startsidan. 
						Jag vet ej vad man ska ha här. Kanske fakta om sidan. VIKTIGT att här få med att det bara gäller SVENSKA orter.
						Övrigt: Kanske prognos för de vanligaste sökningarna. Kanske senaste sökningarna.
						Kanske prognos för där man är med gpd (överkurs) eller tidigare sökningar lagrade i kakor (gaaaaah på den idén!)';


	public function startForm(){
		$html = '
		    <div class="col-xs-12 col-sm-10">
		        <p>'.$this->message.'</p>
		    </div>
		';
		return $html;
	}
}