<?php
class EntryAdmin extends ModelAdmin {

    private static $managed_models = array(
		'Entry'
    );

    private static $url_segment = 'entries';
    private static $menu_title = 'Entries';
	private static $menu_icon = 'site/cms/icons/people-group.png';
}
