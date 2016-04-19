<?php
namespace View;

class SearchView{
	private $searchButton;
	private $message = 'Ett testmeddelande';
	private $city;

	public function searchForm(){
		$html = '
			<div class="row">
				<div class="col-xs-12 col-sm-12"> 
		        <form method="post" role="form" action="?action='.NavigationView::$actionShowForecast.'">
			        <div class="col-xs-12 col-sm-6">
				        <div class="form-group">
					        <input type="text" class="form-control" maxlength="255" name="city" id="city" placeholder="Sök väder via ort" autofocus="">
				        </div>
			        </div>
			        <div class="col-xs-12 col-sm-6">
			            <div class="form-group">
			            	<input type="submit" value="Sök" name="searchButton" class="btn btn-default">
			            </div>
		            </div>
		        </form>
		        	<div class="col-xs-12 col-sm-6">
		        		<p>'.$this->message.'</p>
		        	</div>

	        	</div>
        	</div>
		';
		return $html;
	}
}