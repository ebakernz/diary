<?php

class Entry extends DataObject {
	
	static private $db = array(
		'Title' => 'Varchar',
		'Content' => 'HTMLText',
		'IsDeleted' => 'Boolean(false)'
	);

	static private $has_one = array(
		'Image' => 'Image'
	);

	static private $many_many = array(
		'Categories' => 'Category'
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
		$fieldList->push( ListBoxField::create(
				'Categories', 
				'Category', 
				Category::get()->map('ID', 'Title')->toArray(),
				$value = array(),
				$size = null,
				$multiple = true
			)
		);

		return $fieldList;
	}

	public function FormattedDate() {
		return date('j F, Y', strtotime($this->Created));
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

	public function CategoryList() {
		if($this->Categories()->exists()) {
			$list = '';
			foreach($this->Categories() as $cat) {
				$list .= strtolower(str_replace(' ', '-', $cat->Title)) .' ';
			}

			// Remove last ,
			$list = substr($list, 0, -1);
			return $list;
		} else {
			return 'none';
		}
	}

	public function CategoryListNice() {
		if($this->Categories()->exists()) {
			$list = '';
			foreach($this->Categories() as $cat) {
				$list .= $cat->Title .', ';
			}

			// Remove last ,
			$list = substr($list, 0, -2);
			return $list;
		} else {
			return 'none';
		}
	}

	public function CategoryArray() {
		if($this->Categories()->exists()) {
			return $this->Categories()->toArray();
		}
	}

}