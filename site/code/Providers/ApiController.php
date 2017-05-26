<?php
class ApiController extends Controller {

	private static $allowed_actions = array(
		'handler'
	);

	private static $url_handlers = array(
		'$ApiClass/$ApiAction/$ApiID' => 'handler'
	);

	/** 
	 * Map a DataList of Objects into a simple array
	 *
	 * @param $records = obj
	 * @param $simple = boolean, show only basic record data
	 * @return array
	 **/
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

	/**
	 * Map a single object into an array
	 * DataList->ToArray() can do this, but we want more precision over the output
	 *
	 * @param $records = DataList
	 **/
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
						'URLTitle' => $record->URLTitle()
					);
					break;

				default:
					return $record->ToArray();
			}
		}
	}

	/**
	 * Check authentication of the request
	 *
	 * @param $request SS_HttpRequest
	 * @return boolean
	 **/
	public function CheckAuthentication($request){

		return true;

		/*// logged in user? sweet, all users are okay
		if (Member::currentUserID()){
			return true;

		// authentication token?
		} else if ($access_token = $request->getVar('access_token')){

			// make sure it's the same as our config.yml
			return $access_token == Config::inst()->get('ApiController', 'access_token');
		}

		return false;*/
	}


	/**
	 * API request handler
	 * These are used for ajax requests from ReactJS
	 *
	 * @param $request SS_HTTPRequest
	 **/
	public function handler($request){

		$response = new RestfulService_Response('Unknown error',500);
		$response->addHeader('Content-Type','application/json');

		// check our authentication and block request if appropriate
		$authenticated = $this->CheckAuthentication($request);
		if (!$authenticated){
			$response->setStatusCode(401);
			$response->setBody('{"error": "Not authorized"}');
			return $response;
		}

		// digest our request parameters
		$data = ($request->getBody() ? json_decode($request->getBody(),true) : array());

		$class = $request->param('ApiClass');
		$action = $request->param('ApiAction');
		$id = $request->param('ApiID');
		$vars = $request->getVars();
		$records = array();

		// cache factory
		$cache = SS_Cache::factory('api');
		$cache_key = $class.'_'.$action.'_'.($id ? $id.'_' : '');

		switch ($class){

			/**
			 * =============================================================================== ENTRIES ============
			 * =====================================================================================================
			 **/
			case 'entries':

				$last_edited = Entry::get()->sort('LastEdited DESC')->first();
				if ($last_edited){
					$last_edited = $last_edited->LastEdited;
				}
				$cache_key.= strtotime($last_edited);

				switch ($action){
										
					case 'get':
						if ($cached_body = $cache->load($cache_key)){
							$body = $cached_body;

						} else {
							if ($id){
								$records = Entry::get()->byID($id);
								if (!$records){
									$response->setBody('{"error": "Record not found"}');
									return $response;
								}
								$records = $this->ToArray($records);

							}
							else {
								$active_entries = Entry::get()->filter(array(
									'IsDeleted' => 0
								));
								foreach ($active_entries as $active_entry){
									$active_entry_ids[] = $active_entry->ID;
								}
								$records = Entry::get()->filter(array('IsDeleted' => 0, 'ID' => $active_entry_ids));
								$records = $this->ToArray($records);
							}

							$body = json_encode($records);
							$cache->save($body, $cache_key);
						}

						$response->setBody($body);
						$response->setStatusCode(200);
						break;

					case 'get_categorised':
						/*
						$categories = Category::get();
						$records = $categories->relation('Entries');
						$records = $this->ToArray($records);

						$body = json_encode($records);

						$response->setBody(json_encode($this->ToArray($record)));
						$response->setStatusCode(200);*/
						if ($cached_body = $cache->load($cache_key)){
							$body = $cached_body;

						} else {
							$categories = Category::get();
							$records = $categories->relation('Entries');

							$records = $this->ToArray($records);						

							$body = json_encode($records);
							$cache->save($body, $cache_key);
						}

						$response->setBody($body);
						$response->setStatusCode(200);
						break;
					
					case 'new':
						$record = Entry::create($data);
						$record->write();

						$response->setBody(json_encode($this->ToArray($record)));
						$response->setStatusCode(200);
						break;

					case 'save':
						$record = Entry::get()->byID($id);
						if (!$record->ID || $record->IsDeleted){
							$response->setBody('{"error": "Record not found"}');
							return $response;
						}

						$record->Title = $data['Title'];
						$record->Content = $data['Content'];
						$record->Image = $data['Image'];
						$record->write();

						$response->setBody(json_encode($this->ToArray($record)));
						$response->setStatusCode(200);
						break;
					
					case 'delete':
						$record = Entry::get()->byID($id);
						if (!$record->ID){
							$response->setBody('{"error": "Record not found"}');
							return $response;
						}

						$record->IsDeleted = 1;
						$record->write();

						$response->setBody('{"message": "Record deleted"}');
						$response->setStatusCode(200);
						break;
					
					case 'undelete':
						$record = Entry::get()->byID($id);
						if (!$record->ID){
							$response->setBody('{"error": "Record not found"}');
							return $response;
						}

						$record->IsDeleted = 0;
						$record->write();

						$response->setBody(json_encode($this->ToArray($record)));
						$response->setStatusCode(200);
						break;

				}

				break;	

			case 'categories':
				switch ($action){

					case 'get_by_entry':
						if ($cached_body = $cache->load($cache_key)){
							$body = $cached_body;

						} else {
							if($id) {
								$entry = Entry::get()->byID($id);
								if (!$entry){
									$response->setBody('{"error": "Record not found"}');
									return $response;
								}
								$records = $entry->Categories();
								$records = $this->ToArray($records);
							}

							$body = json_encode($records);
							$cache->save($body, $cache_key);
								
						}

						$response->setBody($body);
						$response->setStatusCode(200);
						break;
				}

				break;

			case 'users':
				switch ($action) {

					case 'get_by_id':

					break;

					case 'new':

					break;

					case 'update':

					break;

					
				}

		}

		return $response;
	}


}
