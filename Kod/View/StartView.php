<?php
namespace View;

class StartView{


	public function startForm(){
		$html = '
			<div class="row">
		    <div class="col-xs-12 col-sm-10">
		        <h1>Väderprognoser från</h1>
		        	<a href="http://www.yr.no">
					<img class="startpagePic" src="https://upload.wikimedia.org/wikipedia/commons/4/48/Yr-logo.png" alt="logo yr" title="logo yr">
					</a>
					<a href="http://www.smhi.se">
					<img class="smhi" src="http://www.smhi.se/polopoly_fs/1.1108.1398236874!/image/SMHIlogo.png_gen/derivatives/Original/SMHIlogo.png" alt="logo smhi" title="logo smhi">
					</a>
		        <p>
		        Senaste sökningarna:
		        </p>
		        <p>
		        bla bla bla bla
		        </p>
		    </div>
		    </div>
		';
		return $html;
	}
}