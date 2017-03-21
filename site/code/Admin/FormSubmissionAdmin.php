<?php
class FormSubmissionAdmin extends ModelAdmin {

    private static $managed_models = array(
		'FormSubmission'
    );

    private static $url_segment = 'form-submissions';
    private static $menu_title = 'Submissions';
	private static $menu_icon = 'site/cms/icons/email.png';
	
}


