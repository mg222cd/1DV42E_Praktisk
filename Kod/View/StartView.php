<?php
namespace View;

class StartView{


	public function startForm(){
		$html = '
			<div class="row">
		    <div class="col-xs-12 col-sm-10">
		        <h1>
		        	Väderprognoser från
		        	<a href="http://www.yr.no">
					<img class="startpagePic startLogos" src="https://upload.wikimedia.org/wikipedia/commons/4/48/Yr-logo.png" alt="logo yr" title="logo yr">
					</a>
					och
					<a href="http://www.smhi.se">
					<img class="startLogos" src="http://www.smhi.se/polopoly_fs/1.1108.1398236874!/image/SMHIlogo.png_gen/derivatives/Original/SMHIlogo.png" alt="logo smhi" title="logo smhi">
					</a>
				</h1>
		        <h2 class="darkblueAsInHeader">
		        Senaste sökningarna:
		        </h2>
		    </div>
		    </div>
		';
		return $html;
	}
}