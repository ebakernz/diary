<?php
class FormSubmission extends DataObject {	
		
	static private $db = array(
		'FormData' => 'Text',
		'Name' => 'Varchar(255)',
		'Email' => 'Varchar(255)'
	);
		
	static private $has_one = array(
		'Page' => 'Page'
	);
	
	static $summary_fields = array(
		'Created' => 'Date',
		'Name' => 'Name',
		'Email' => 'Email'
	);
	
	static $default_sort = 'Created DESC';
	
	public static $searchable_fields = array(
		'Created',
		'Name',
		'Email'
	);
}