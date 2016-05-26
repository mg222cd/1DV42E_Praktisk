<?php
namespace View;

class StartView{


	public function startForm(){
		$html = '
		    <div class="col-xs-12 col-sm-10">
		        <h1>Väderprognoser från
		        	<a href="http://www.yr.no">
					yr.no
					</a>
					och
					<a href="http://www.smhi.se">
					smhi.se
					</a>
		        </h1>
		        <p>
		        Senaste sökningarna:
		        </p>
		        <p>
		        bla bla bla bla
		        </p>
		        
		    </div>
		';
		return $html;
	}
}