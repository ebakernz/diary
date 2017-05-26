<?php

/*
	Add user profile (name, image, password)
	Add user's categories
 */

class Settings extends Page {

	private static $db = array(

	);
	
	private static $has_many = array(
		'Categories' => 'Category'
	);

}

class Settings_Controller extends Page_Controller {

	public function init() {
		parent::init();

		// Set default values in the config if missing.  These things can't be defined in the config
		// file because insufficient information exists when that is being processed
		$htmlEditorConfig = HTMLEditorConfig::get_active();
		$htmlEditorConfig->setOption('language', i18n::get_tinymce_lang());
		$htmlEditorConfig->addButtonsToLine(1, 'code', 'link', 'unlink');
		$htmlEditorConfig->insertButtonsBefore('formatselect', 'styleselect');
	}

	private static $allowed_actions = array(
		'Form',
		'EditorToolbar'
	);

	public function EditorToolbar() {
        return HtmlEditorField_Toolbar::create($this, "EditorToolbar");
    }	

    function IsLoggedIn() {
    	// Is a member logged in?
		if( Member::currentUserID() ) {
		    return true;
		}
    }

	/**
	 * Form for user to create member account (name, password, profile image)
	 * Add member to group 'Bloggers'
	 * @return Form obj
	 **/
	public function Form(){

        $member = Member::currentUser();

		$fieldList = FieldList::create(array());

		$fieldList->push( HiddenField::create('ID','ID') );
		$fieldList->push( TextField::create('Name', 'Name') );
		$avatar = new UploadField('Avatar');
		$avatar->setFolderName('Avatars');
		$fieldList->push( $avatar );
		$fieldList->push( EmailField::create('Email', 'Email') );	
		$fieldList->push( ConfirmedPasswordField::create('Password', 'Password') );	

        $actions = FieldList::create(
            FormAction::create("doForm")->setTitle("Submit")->addExtraClass('productive'),
            FormAction::create("cancel")->setTitle("Cancel")
        );

        $form = Form::create($this, 'Form', $fieldList, $actions);

       	if($member){
        	$form->loadDataFrom($member);
        }

        return $form;
	}

	/**
	 * Form to facilitate editing/creating dataobjects
	 *
	 * @param $data form data
	 * @param $form Form obj
	 **/
	public function doForm($data, $form){

		if (isset($data['ID']) && $data['ID'] > 0){
			$member = Entry::get()->byID($data['ID']);
		} else {
			$member = Entry::create();
		}

		$form->saveInto($member);
		$member->write();

		$this->redirect($member->Link());
	}


	/*
		Form for adding categories for the user
	 */
	function CategoryForm() {

		$member = Member::currentUser();

		// Need to sort out how going to handle multiple instances of category
		// front end grid field : https://github.com/webbuilders-group/silverstripe-frontendgridfield
		// grid field extension : https://github.com/silverstripe-australia/silverstripe-gridfieldextensions
		$category = Category::get()->first();
		$fields = $category->FormFields();

        $actions = FieldList::create(
            FormAction::create("doCategoryForm")->setTitle("Submit")->addExtraClass('productive'),
            FormAction::create("cancel")->setTitle("Cancel")
        );

        $form = Form::create($this, 'CategoryForm', $fields, $actions);

        return $form;

	}

	function doCategoryForm() {
		Debug::show($data);
		if (isset($data['ID']) && $data['ID'] > 0){
			$category = Category::get()->byID($data['ID']);
		} else {
			$category = Category::create();
		}

		$form->saveInto($category);
		$category->write();

		$this->redirect($category->Link());		
	}


}