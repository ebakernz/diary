<?php

class CalendarPage extends Page {
}

class CalendarPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();

		// Set default values in the config if missing.  These things can't be defined in the config
		// file because insufficient information exists when that is being processed
		$htmlEditorConfig = HTMLEditorConfig::get_active();
		$htmlEditorConfig->setOption('language', i18n::get_tinymce_lang());
		$htmlEditorConfig->addButtonsToLine(1, 'code', 'sslink');
		$htmlEditorConfig->insertButtonsBefore('formatselect', 'styleselect');
	}

	private static $allowed_actions = array(
		'Form',
		'view',
		'new',
		'edit',
		'EditorToolbar'
	);

	private static $url_handlers = array(
		'new' => 'new',
		'view/$ID!' => 'view',
		'edit/$ID!' => 'edit'
	);

	public static $Entry;

	public function Entries() {
		return Entry::get();
	}

	/** 
	 * Get the current entry (by URL param)
	 **/
	public function getEntry(){

		$id = $this->getRequest()->param('ID');
		if (!$id) return false;

		$entry = Entry::get()->byID($id);
		if (!$entry || $entry->ID <= 0) return false;

		return $entry;
	}

	public function EditorToolbar() {
        return HtmlEditorField_Toolbar::create($this, "EditorToolbar");
    }

    /**
	 * Request to view an entry
	 **/
	public function view(SS_HTTPRequest $request){
		$entry = $this->getEntry();
		$this->Entry = $entry;
		$this->MenuTitle = $entry->Title;
		return array();
	}

	/**
	 * Request to edit an entry
	 **/
	public function edit(SS_HTTPRequest $request){
		$entry = $this->getEntry();
		$this->Entry = $entry;
		$this->MenuTitle = 'Editing entry '.$entry->Title;
		return array();
	}

	/**
	 * Form to add/edit entries
	 *
	 * @return Form obj
	 **/
	public function Form(){

        $entry = $this->getEntry();

		$fields = Entry::FormFields();

        $actions = FieldList::create(
            FormAction::create("doForm")->setTitle("Submit")->addExtraClass('productive'),
            FormAction::create("cancel")->setTitle("Cancel")
        );

        $form = Form::create($this, 'Form', $fields, $actions);

       	if($entry){
        	$form->loadDataFrom($entry);
        }

        return $form;
	}

	/**
	 * Form to facilitate editing/creating dataobjects
	 *
	 * @param $data form data
	 * @param $form Form obj
	 **/
	public function cancel($data, $form){

		if (!isset($data['ID']) || $data['ID'] <= 0){
			return $this->redirect($this->Link());
		}

		$entry = Entry::get()->byID($data['ID']);
		return $this->redirect($entry->Link());
	}

	/**
	 * Form to facilitate editing/creating dataobjects
	 *
	 * @param $data form data
	 * @param $form Form obj
	 **/
	public function doForm($data, $form){

		if (isset($data['ID']) && $data['ID'] > 0){
			$entry = Entry::get()->byID($data['ID']);
		} else {
			$entry = Entry::create();
		}

		$form->saveInto($entry);
		$entry->write();

		$this->redirect($entry->Link());
	}


}