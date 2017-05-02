<?php

class Category extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar'
	);

	private static $has_one = array(
		'Page' => 'CalendarPage'
	);

	private static $belongs_many_many = array(
		'Entries' => 'Entry'
	);

	private static $summary_fields = array(
		'Title' => 'Title'
	);

	public function URLTitle() {
		return strtolower(str_replace(' ', '-', $this->Title));
	}

}