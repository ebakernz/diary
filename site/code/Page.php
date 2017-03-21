<?php
class Page extends SiteTree {

	private static $db = array();

	private static $has_one = array();
	
	public function getCMSFields(){	
		$fields = parent::getCMSFields();		
		return $fields;
	}
	
	/**
	 * Get this model's controller
	 * @return obj
	 */
	public function MyController(){
		$class = $this->ClassName . "_Controller";
		$controller = new $class($this);
		return $controller;
	}


	/**
	 * Get a link to a specific Section
	 * Fetches a page class (eg ServersPage) and returns a link
	 *
	 * @param $class string
	 * @return string
	 **/
	public static function SectionLink($class){
		$page = $class::get()->first();
		if (!$page || $page->ID <= 0 || !isset($page->ID)) return false;
		return $page->Link();
	}
	
	function URLTitle() {
		return strtolower(str_replace('', '-', $this->Title));
	}
}

class Page_Controller extends ContentController {

	private static $allowed_actions = array();

	/**
	 * When we initialize this controller
	 * This happens during the birth of the universe
	 **/
	public function init() {	
		parent::init();
		
		// global compiled javascript
		if( Director::isLive() ){
			Requirements::javascript('site/production/index.min.js');
		}else{
			Requirements::javascript('site/production/index.js');
		}
		
		// global css (compiled scss)
		if( Director::isLive() ){
			Requirements::css('site/production/index.min.css');
		}else{
			Requirements::css('site/production/index.css');
		}

		Requirements::css('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Pacifico');
	}



}