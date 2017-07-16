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
		
		if($this->ClassName == 'MapPage') {
			Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBsGcLisYoTvB7GguIAy0RujzP3NO8ZOHc&libraries=drawing');		
		}

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

		Requirements::set_force_js_to_bottom(true);

	}

	function Catgorised() {
		$categories = Category::get();
		$records = $categories->relation('Entries');
		Debug::show($records);
		$records = $this->ToArray($records);
		Debug::show($records);
		return $records;
	}

	public function ToArray($records, $simple = false){
		$array = [];

		// list of records
		if (is_array($records) ||
			$records->class == 'ArrayList' ||
			$records->class == 'DataList' ||
			$records->class == 'HasManyList' ||
			$records->class == 'ManyManyList' ){
			foreach ($records as $record){			
				$array_ified = $this->RecordToArray($record, $simple);
				$array[] = $array_ified;
			}
		} else {
			$array = $this->RecordToArray($records, $simple);
		}

		return $array;
	}

	public function RecordToArray($record, $simple = false){

		if ($simple){

			$array = array(
				'ID' => $record->ID,
				'Title' => $record->Title,
				'Link' => $record->Link()
			);
			if ($record->ClassName == 'Server'){
				$array['Host'] = $record->Host;
			}
			return $array;

		} else {

			switch ($record->ClassName){

				case 'Entry':

					return array(
						'ID' => $record->ID,
						'Date' => $record->FormattedDate(),
						'Title' => $record->Title,
						'Content' => $record->Content,
						'SummaryText' => $record->SummaryText(),
						'Image' => ($record->Image()->exists() ? $record->Image()->URL : null),			
						'Link' => $record->Link(),
						'EditLink' => $record->EditLink(),
						'Categories' => $this->ToArray($record->Categories()),
						'canEdit' => $record->canEdit(),
						'canDelete' => $record->canDelete()
					);
					break;

				case 'Category':

					return array(
						'ID' => $record->ID,
						'Title' => $record->Title,
						'URLTitle' => $record->URLTitle(),
					);
					break;

				default:
					return $record->ToArray();
			}
		}
	}
	
}