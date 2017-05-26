<?php

class MapPage extends Page {
	
} 

class MapPageController extends Page_Controller {
	
	public function init() {	
		parent::init();
		Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBsGcLisYoTvB7GguIAy0RujzP3NO8ZOHc&libraries=drawing&callback=initMap');		
	}

}