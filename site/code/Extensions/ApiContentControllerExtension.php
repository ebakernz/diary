<?php
class ApiContentControllerExtension extends DataExtension {

	private static $allowed_actions = array(
		'api'
	);

	/**
	 * All api requests
	 * These are used for ajax requests from ReactJS
	 *
	 * @param $request SS_HTTPRequest
	 **/
	public function api($request){

		$response = new RestfulService_Response('json request failed',500);
		$class = $request->param('ID');
		$vars = $request->getVars();

		switch ($class){

			case 'entries':
				if ($request->isGET()){
					$records = Entry::get();
					$records = $this->EntriesToArray($records);
					$response->setBody(json_encode($records));
					$response->setStatusCode(200);
				}
				break;
		}

		return $response;
	}


	/** 
	 * Map a DataList of Entries into a simple array
	 * @param $records
	 * @return array
	 **/
	public function EntriesToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = array(
				'ID' => $record->ID,
				'Title' => $record->Title,
				'Content' => $record->Content,
				'SummaryText' => $record->SummaryText(),
				'Image' => ($record->ImageID && $record->Image()->ID ? $record->Image()->SetWidth(200)->URL : null),
				'EditLink' => $record->EditLink(),
				'Link' => $record->Link(),
				'canEdit' => $record->canEdit()
			);
		}

		return $array;
	}


	


	/** 
	 * Map a DataList of Websites into a simple array
	 * @param $records
	 * @return array
	 **/
	/*public function ClientsToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = array(
				'ID' => $record->ID,
				'Title' => $record->Title,
				'Hosting' => $record->Hosting,
				'Hosting_Other' => $record->Hosting_Other,
				'SLAExpiry' => $record->SLAExpiry,
				'Notes' => $record->Notes,
				'Image' => ($record->ImageID && $record->Image()->ID ? $record->Image()->SetWidth(200)->URL : null),
				'Link' => $record->Link(),
				'EditLink' => $record->EditLink(),
				'Contacts' => $this->ContactsToArray($record->Contacts()),
				'Manager' => null, //TODO,
				'Websites' => $this->WebsitesToArray($record->Websites()),
				'canEdit' => $record->canEdit()
			);
		}

		return $array;
	}
*/



	/** 
	 * Map a DataList of Contacts into a simple array
	 * @param $records
	 * @return array
	 **/
	/*public function ContactsToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = array(
				'ID' => $record->ID,
				'Title' => $record->Title(),
				'Name' => $record->Name,
				'Email' => $record->Email,
				'Phone' => $record->Phone,
				'Mobile' => $record->Mobile,
				'Position' => $record->Position,
				'IsPrimary' => $record->IsPrimary,
				'Link' => $record->Link()
			);
		}

		return $array;
	}
*/

	/** 
	 * Map a DataList of Websites into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function WebsitesToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = $this->WebsiteToArray($record);
		}

		return $array;
	}
*/

	/** 
	 * Map a Website into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function WebsiteToArray($record){
		return array(
			'ID' => $record->ID,
			'Title' => $record->Title,
			'Platform' => $record->Platform,
			'Platform_Other' => $record->Platform_Other,
			'Link' => $record->Link(),
			'EditLink' => $record->EditLink(),
			'ClientID' => $record->ClientID,
			'RepositoryID' => $record->RepositoryID,
			'canEdit' => $record->canEdit()
		);
	}
*/

	/** 
	 * Map a DataList of Activity (Service, Releases, etc) into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function ActivitiesToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = $this->ActivityToArray($record);
		}

		return $array;
	}
*/

	/** 
	 * Map a DataList of Activity (Service, Releases, etc) into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function ActivityToArray($record){

		if ($record->ClassName == 'Service'){
			if ($record->DateCompleted){
				$date = $record->DateCompleted;
			} else {
				$date = $record->Created;
			}
		} else {
			$date = $record->Date;
		}

		$ago = SS_Datetime::create();
		$ago->setValue($date);
		$ago = $ago->Ago();

		return array(
			'ID' => $record->ID,
			'ClassName' => $record->ClassName,
			'Title' => ($record->ClassName == 'Job' ? 'J-'.$record->ID : $record->Title),
			'Description' => ($record->ClassName == 'Job' ? $record->Title : $record->Description),
			'Date' => $date,
			'Date_Ago' => $ago,
			'DateCompleted' => ($record->DateCompleted ? $record->DateCompleted : null),
			'Member' => ($record->MemberID ? $this->MemberToArray($record->Member()) : null),
			'WebsiteID' => $record->WebsiteID,
			'canEdit' => $record->canEdit()
		);
	}*/


	/** 
	 * Map a single Member object into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function MemberToArray($record){
		return array(
			'ID' => $record->ID,
			'Name' => $record->Name,
			'FirstName' => $record->FirstName,
			'Surname' => $record->Surname,
			'Email' => $record->Email,
			'Link' => $record->Link()
		);
	}
*/

	/** 
	 * Map a DataList of Logins into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function LoginsToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = $this->LoginToArray($record);
		}

		return $array;
	}
*/

	/** 
	 * Map a DataList of Logins into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function LoginToArray($record){
		return array(
			'ID' => $record->ID,
			'Type' => $record->Type,
			'Type_Other' => $record->Type_Other,
			'Username' => $record->Username,
			'Password' => $record->Password,
			'Notes' => $record->Notes,
			'IsPrimary' => $record->IsPrimary,
			'ClientID' => $record->ClientID,
			'ServerID' => $record->ServerID,
			'Server' => ($record->Server()->ID ? array('Host' => $record->Server()->Host, 'Link' => $record->Server()->Link()) : null),
			'WebsiteID' => $record->WebsiteID,
			'Website' => ($record->Website()->ID ? array('Title' => $record->Website()->Title, 'Link' => $record->Website()->Link()) : null),
			'canEdit' => $record->canEdit()
		);
	}*/


	/** 
	 * Map a DataList of Repositories into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function RepositoriesToArray($records){
		$array = [];

		foreach ($records as $record){
			$array[] = $this->RepositoryToArray($record);
		}

		return $array;
	}
*/

	/** 
	 * Map a DataList of Repositories into a simple array
	 * @param $records
	 * @return array
	 **/
/*	public function RepositoryToArray($record){
		return array(
			'ID' => $record->ID,
			'Title' => $record->Title,
			'FullName' => $record->FullName,
			'Description' => $record->Description,
			'Updated' => $record->Updated,
			'Link' => $record->Link,
			'IsDeleted' => $record->IsDeleted
		);
	}

*/





	/**
	 * Perform a search
	 *
	 * @param $type string
	 * @param $query string
	 * @return array
	 **/
/*	public function PerformSearch($type, $query){
		$results = array();

		switch($type){

			case 'websites':
				$results = Website::get()->filterAny(array(
					'Title:PartialMatch' => $query,
					'Aliases:PartialMatch' => $query
				));
				$results = $this->WebsitesToArray($results);
				break;

			case 'contacts':
				$results = Contact::get()->filterAny(array(
					'ID' => $query,
					'Name:PartialMatch' => $query,
					'Email:PartialMatch' => $query,
					'Mobile:PartialMatch' => $query,
					'Phone:PartialMatch' => $query
				));
				$results = $this->ContactsToArray($results);
				break;

			case 'clients':
				$results = Client::get()->filterAny(array(
					'ID' => $query,
					'Title:PartialMatch' => $query
				));
				$results = $this->ClientsToArray($results);
				break;
		}

		return $results;
	}*/


}