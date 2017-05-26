<?php

class MemberDecorator extends DataExtension {

	private static $has_one = array(
		'Avatar' => 'Image'
	);

	public function updateCMSFields(FieldList $currentFields) {
		$avatar = new UploadField('Avatar');
		$avatar->setFolderName('Avatars');
		$currentFields->addFieldToTab("Root.Avatar", $avatar);
	}

}