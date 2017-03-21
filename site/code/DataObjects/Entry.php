<?php

class Entry extends DataObject {
	
	static private $db = array(
		'Title' => 'Varchar',
		'Content' => 'HTMLText'
	);

	static private $has_one = array(
		'Image' => 'Image'
	);

	static $default_sort = 'Created DESC';

	static $summary_fields = array(
		'Image.CMSThumbnail' => 'Image',
		'Title' => 'Title'
	);

	/** 
	 * The form fields to edit/create this object
	 *
	 * @return FieldList obj
	 **/
	public static function FormFields(){

		$fieldList = FieldList::create(array());

		$fieldList->push( HiddenField::create('ID','ID') );
		$fieldList->push( TextField::create('Title', 'Title') );
		$fieldList->push( HtmlEditorField::create('Content', 'Content') );
		$fieldList->push( UploadField::create('Image','Image') );

		return $fieldList;
	}

	/* Create summary text */
	public function SummaryText() {
		$words = explode(" ", $this->Content);
		return implode(" ", array_splice($words, 0, 15));
	}

	public function Link(){
		return Page::SectionLink('CalendarPage').'view/'.$this->ID;
	}

	public function EditLink() {
		return Page::SectionLink('CalendarPage').'edit/'.$this->ID;
	}
}