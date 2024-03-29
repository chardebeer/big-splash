<?php

class UniteCreatetorParamsProcessorMultisource{
	
	private $objProcessor;
	private $addon;
	private $name, $nameParam, $param, $processType, $inputData, $arrValues;
	private $isInsideEditor = false;
	private $itemsType;
	private $debugJsonCsv = false;
	private $showDebugData = false;
	private $showDebugMeta = false;
	
	private static $showItemsDebug = false;		//show items debug next output
	
	
	const SOURCE_REPEATER = "repeater";
	const SOURCE_JSONCSV = "json_csv";
	const SOURCE_POSTS = "posts";
	const SOURCE_DEMO = "demo";
	const SOURCE_TERMS = "terms";
	const SOURCE_USERS = "users";
	const SOURCE_MENU = "menu";
	const SOURCE_INSTAGRAM = "instagram";
	
	
	
	/**
	 * 
	 * init the class
	 */
	public function init($objProcessor){
		
		$this->objProcessor = $objProcessor;
		$this->addon = $objProcessor->getAddon();
		
	}
	
	private function _______GET_DATA________(){}
	
	
	/**
	 * get posts data
	 */
	private function getData_posts(){
		
		
		$paramPosts = $this->param;
		
		$paramPosts["name"] = $this->nameParam;
		$paramPosts["name_listing"] = $this->name;
		$paramPosts["use_for_listing"] = true;

		$dataResponse = $this->objProcessor->getPostListData($this->arrValues, $paramPosts["name"], $this->processType, $paramPosts, $this->inputData);
		
		$arrPosts = UniteFunctionsUC::getVal($dataResponse, $this->name."_items");
		
		//debug meta
		
		if($this->showDebugMeta == true)
			HelperUC::$operations->putPostsCustomFieldsDebug($arrPosts);
		
		//get the post items array
		
		$arrImageSizes = null;
		if(!empty($this->itemsImageSize))
			$arrImageSizes = array("desktop"=>$this->itemsImageSize);
		
		$arrPostItems = array();
		
		foreach($arrPosts as $post){
		
			$postItem = $this->objProcessor->getPostDataByObj($post, null, $arrImageSizes);
						
			$arrPostItems[] = $postItem;
		}
		
				
		return($arrPostItems);
	}
	
	
	/**
	 * get terms data
	 */
	private function getData_terms(){

		$paramTerms = $this->param;
		
		$paramTerms["name"] = $this->nameParam;
		$paramTerms["name_listing"] = $this->name;
		$paramTerms["use_for_listing"] = true;
		
		$arrTerms = $this->objProcessor->getWPTermsData($this->arrValues, $paramTerms["name"], $this->processType, $paramTerms, $this->inputData);
		
		if($this->showDebugMeta == true)
			HelperUC::$operations->putTermsCustomFieldsDebug($arrTerms);
		
		
		return($arrTerms);
	}
	
	
	/**
	 * get users data
	 */
	private function getData_users(){
		
		$paramUsers = $this->param;
		
		$paramUsers["name"] = $this->nameParam;
		$paramUsers["name_listing"] = $this->name;
		$paramUsers["use_for_listing"] = true;
		
		$arrUsers = $this->objProcessor->getWPUsersData($this->arrValues, $paramUsers["name"], $this->processType, $paramUsers);
		
		return($arrUsers);
	}
	
	
	
	
	
	/**
	 * get menu data
	 */
	private function getData_menu(){
		
		$menuID = UniteFunctionsUC::getVal($this->arrValues, $this->nameParam."_id");
				
		//get first menu
		if(empty($menuID))
			return(array());
		
		$arrItems = UniteFunctionsWPUC::getMenuItems($menuID);

		
		return($arrItems);
	}
	
	
	
	/**
	 * get repeater data
	 */
	private function getData_repeater(){
		
		
		$nameParamRepeater = $this->name."_repeater";
		
		$repeaterName = UniteFunctionsUC::getVal($this->arrValues, $this->name."_repeater_name");
		
		$location = UniteFunctionsUC::getVal($this->arrValues, $this->name."_repeater_location");
		
		$arrRepeaterItems = array();
		
		$postID = null;
		$post = null;
		$termID = null;
		$userID = null;
		
		switch($location){
			case "selected_post":
				
				$repeaterPostID = UniteFunctionsUC::getVal($this->arrValues, $this->name."_repeater_post");
				
				if(empty($repeaterPostID) || is_numeric($repeaterPostID) == 0){
					
					if($this->showDebugData == true)
						dmp("wrong post id $repeaterPostID");
					
					return(null);
				}
								
				$postID = $repeaterPostID;
				
				$post = get_post($postID);
				
				if(empty($post)){
					
					if($this->showDebugData == true)
						dmp("post with id: $postID not found");
					
					return(null);
				}
				
			break;
			case "current_post":
				
				$post = get_post();
				
				if(empty($post)){
					
					if($this->showDebugData == true)
						dmp("get data from current post - no current post found");
					
					return(null);
				}
				
				$postID = $post->ID;
				
			break;
			case "parent_post":
				
				$post = get_post_parent();
				
				if(empty($post)){
					
					if($this->showDebugData == true)
						dmp("get data from parent post - no parent post found");
					
					return(null);
				}
				
				$postID = $post->ID;
				
			break;
			case "current_term":
				
				$termID = UniteFunctionsWPUC::getCurrentTermID();
								
				if(empty($termID)){
				
					if($this->showDebugData == true)
						dmp("get data from current term - no current term found. try to load from some category archive page.");
					
					return(null);
				}
				
			break;
			case "parent_term":
				
				$termID = UniteFunctionsWPUC::getCurrentTermID();
								
				if(empty($termID)){
				
					if($this->showDebugData == true)
						dmp("get parent term - no current term found. try to load from some category archive page.");
					
					return(null);
				}
				
				$termID = wp_get_term_taxonomy_parent_id($termID);
				
				if(empty($termID)){
					
					if($this->showDebugData == true)
						dmp("get parent term - no parent term found from term id: $termID. check this term if it has parent.");
					
					return(null);
				}
				
			break;
			case "current_user":
				
				$userID = get_current_user_id();
				
				if(empty($userID)){
					
					if($this->showDebugData == true)
						dmp("get current user no logged in user found.");
					
					return(null);
				}

			break;
			default:
				dmp("get data from location: $location !!!!!!!!!!!!!!!!!!!!!");
			break;
		}
		
		if(empty($repeaterName)){
			
			dmp("items from repeater: please enter repeater name");
			return(array());
		}
		
		
		//---- load from post
		
		if(!empty($postID)){
			
			$arrCustomFields = UniteFunctionsWPUC::getPostCustomFields($postID, false, $this->itemsImageSize);
			
		}
		
		//------ load from term
		
		if(!empty($termID)){
			
			$arrCustomFields = UniteFunctionsWPUC::getTermCustomFields($termID, false);
		}
		
		if(!empty($userID))
			$arrCustomFields = UniteFunctionsWPUC::getUserCustomFields($userID, false);

		$arrRepeaterItems = UniteFunctionsUC::getVal($arrCustomFields, $repeaterName);
		
		//show debug meta text
		
		if($this->showDebugMeta == true){
			
			if(!empty($postID)){
				
				$text = "Post <b>".$post->post_title." ($postID)</b>";
				
				HelperUC::$operations->putCustomFieldsArrayDebug($arrCustomFields, $text);
			}
			
			if(!empty($termID)){
				
				$text = "Term <b>".$term->name." ($termID)</b>";
				
				HelperUC::$operations->putCustomFieldsArrayDebug($arrCustomFields, $text);
			}
			
			if(!empty($userID)){
				
				$text = "User <b>".$user["name"]." ($userID)</b>";
				
				HelperUC::$operations->putCustomFieldsArrayDebug($arrCustomFields, $text);
			}
			
			
		}
		
		//show debug data text
		
		if($this->showDebugData == true){
			
			$text = "Getting meta data from field: <b>$repeaterName</b> from <b>$location</b>";
			
			switch($location){
				case "parent_post":
				case "selected_post":
				case "current_post":
						$text .= ", <b>".$post->post_title."</b>";
				break;
				case "current_term":
				case "parent_term":
					
					$term = get_term($termID);
					
					$text .= ", <b>".$term->name."</b>";
				break;
				case "current_user":
					
					$user = UniteFunctionsWPUC::getUserData($userID);
					
					$userName = UniteFunctionsUC::getVal($user, "name");
					
					$text .= ", <b>".$userName."</b>";
					
				break;
			}
			
			dmp($text);
		}
		
		
		//get the data from repeater
		
		if(empty($arrRepeaterItems) && !empty($postID) ){
			
			$previewID = UniteFunctionsUC::getGetVar("preview_id","",UniteFunctionsUC::SANITIZE_TEXT_FIELD);

			if(!empty($previewID)){
				dmp("preview data from repeater: you are under elementor preview, the output may be wrong. Please open the post without the preview");
			}
			
			return(array());
		}
		
		if(is_array($arrRepeaterItems) == false)
			return(array());
		
		
		return($arrRepeaterItems);
	}
	
	
	/**
	 * add dynamic field items
	 */
	private function getData_jsonCsv(){
		
		$showDebug = $this->showDebugData;
		
		if($showDebug == true){
			dmp("---- the debug is ON, please turn it off before release --- ");
		}
				
		$contentLocation = UniteFunctionsUC::getVal($this->arrValues, $this->name."_json_csv_location");
		
		if($contentLocation == "url"){
			
			$url = UniteFunctionsUC::getVal($this->arrValues, $this->name."_json_csv_url");
			
			if(empty($url)){
				
				if($showDebug)
					dmp("no url found for json csv");
				
				return(null);
			}
			
			$dynamicFieldValue = HelperUC::$operations->getUrlContents($url, $showDebug);
			
		}else{
			$dynamicFieldValue = UniteFunctionsUC::getVal($this->arrValues, $this->name."_json_csv_dynamic_field");
		}
				
		if(empty($dynamicFieldValue)){
			
			if($showDebug)
				dmp("no data given in the dynamic field");
			
			return(null);
		}
		
		//try json
		
		$arrData = UniteFunctionsUC::maybeJsonDecode($dynamicFieldValue);
		
		//debug JSON
		
		if($showDebug == true && is_array($arrData)){
			
			dmp("JSON data found: ");
			dmp($arrData);
			
			dmp("------------------------------");
			
			return($arrData);
		}
		
		//if not, try csv
		if(is_array($arrData) == false)
			$arrData = UniteFunctionsUC::maybeCsvDecode($arrData);

		//debug CSV
		
		if($showDebug == true && is_array($arrData)){
			
			dmp("CSV data found: ");
			dmp($arrData);			
		}
		
		if(is_array($arrData) == false){
			
			if($showDebug == true){
				dmp("No CSV or JSON data found. The input is: ");
				dmp($dynamicFieldValue);
				dmp("------------------------------");
			}
						
			return(null);
		}
		
		
		if($showDebug)
			dmp("------------------------------");
		
		
		return($arrData);
	}
	
	
	/**
	 * get instagram data
	 */
	private function getData_instagram(){
		
		$paramInstagram = $this->param;
		
		$paramInstagram["name"] = $this->nameParam;
		
		$arrData = $this->objProcessor->getInstagramData($this->arrValues, $this->nameParam, $paramInstagram);
		
		if(empty($arrData))
			return(array());
		
		$items = UniteFunctionsUC::getVal($arrData, "items");
		
		if(empty($items))
			return(array());
	
		//modify items - add type
		
		foreach($items as $key=>$item){
			
			unset($item["video_class"]);
			unset($item["num_video_views"]);
			unset($item["num_likes"]);
			unset($item["num_comments"]);
			
			$isVideo = UniteFunctionsUC::getVal($item, "isvideo");
			
			$item["type"] = $isVideo?"video":"image";
			
			$item["caption_text"] = UniteFunctionsUC::getVal($item, "caption");
			
			
			unset($item["isvideo"]);
			unset($item["caption"]);
			
			
			$items[$key] = $item;
		}
		
		return($items);			
	}
	
	
	/**
	 * get multisource data
	 */
	private function getData($source){
		
		switch($source){
			case self::SOURCE_POSTS:
				
				$arrPosts = $this->getData_posts();
				
				return($arrPosts);
			break;
			case self::SOURCE_REPEATER:
				
				$arrRepeaterItems = $this->getData_repeater();
				
				return($arrRepeaterItems);
			break;
			case self::SOURCE_JSONCSV:
				
				$arrDynamicFieldItems = $this->getData_jsonCsv();
				
				return($arrDynamicFieldItems);
			break;
			case self::SOURCE_TERMS:
				
				$arrTerms = $this->getData_terms();
				
				return($arrTerms);
			break;
			case self::SOURCE_USERS:
				
				$arrUsers = $this->getData_users();
				
				return($arrUsers);
			break;
			case self::SOURCE_MENU:
				
				$arrMenu = $this->getData_menu();
				
				return($arrMenu);
			break;
			case self::SOURCE_INSTAGRAM:
				
				$arrInstagram = $this->getData_instagram();
				
				return($arrInstagram);
			break;
			default:
				
				UniteFunctionsUC::throwError("getData error, Wrong items source: $source");
			break;
		}
		
		
	}
	
	
	/**
	 * check debug vars before get data
	 */
	private function checkDebugBeforeData($itemsSource){
		
		switch($itemsSource){
			case self::SOURCE_JSONCSV:
				
				$isDebugJsonCsv = UniteFunctionsUC::getVal($this->arrValues, $this->name."_debug_jsoncsv_data");
				$isDebugJsonCsv = UniteFunctionsUC::strToBool($isDebugJsonCsv);
				
				if($isDebugJsonCsv == true)
					$this->debugJsonCsv = true;
				
				//show json and csv examples
					
				$isShowExamples = UniteFunctionsUC::getVal($this->arrValues, $this->name."_show_example_jsoncsv");
				$isShowExamples = UniteFunctionsUC::strToBool($isShowExamples);
				
				if($isShowExamples == true)
					$this->printJsonCsvExamples();
				
			break;
		}
		
		
	}
	
	/**
	 * print debug json or csv examples
	 */
	private function printJsonCsvExamples(){
		
		dmp("----- Show JSON CSV examples is ON. Please turn it OFF before release");
		
		//-------- show the json
		
		dmp("JSON content example:");
		
		$arrExample = array();
		$arrExample[] = array("title"=>"Google","number"=>10, "link"=>"https://google.com");
		$arrExample[] = array("title"=>"Yahoo","number"=>20,"link"=>"https://yahoo.com");
		$arrExample[] = array("title"=>"Bing","number"=>30,"link"=>"https://bing.com");
		
		$json = json_encode($arrExample);
		
		$css = "border:1px solid gray;background-color:lightgray;padding:10px;";
		
		echo "<div style='{$css}'>";
			dmp($json);
		echo "</div>";
		
		
		//------- show the csv
		
		dmp("CSV content example:");
		
		$csv = UniteFunctionsUC::arrayToCsv($arrExample);
		
		$css = "border:1px solid gray;background-color:lightgray;padding:10px;";
		
		echo "<div style='{$css}'>";
			dmp($csv);
		echo "</div>";
		
		echo "<br>";
		echo "<br>";
		
	}
	
	
	/**
	 * show debug
	 */
	private function showDebug($source, $arrData){
		
		if($this->showDebugData){
			
			if($source == self::SOURCE_DEMO){
				dmp("Switching to demo data source in editor only.");
			}
			
			$numItems = count($arrData);
			
			dmp("Input data from: <b>$source</b>, found: $numItems");
			dmp($arrData);
		}
		
		
		
	}
	
	/**
	 * get all fields from the values
	 */
	private function getFields(){
		
		$arrFields = array();
		
		foreach($this->arrValues as $key => $value){
			
			$prefix = $this->nameParam."_field_source_";
			
			$pos = strpos($key, $prefix);
			
			if($pos === false)
				continue;
			
			$arrFields[$key] = $value;
		}
		
		return($arrFields);
	}
	
	private function _______GET_FIELD_VALUE________(){}

	
	/**
	 * modify param value
	 */
	private function modifyParamValue($value, $param){
		
		$paramType = UniteFunctionsUC::getVal($param, "type");

		switch($paramType){
			case UniteCreatorDialogParam::PARAM_NUMBER:
			case UniteCreatorDialogParam::PARAM_SLIDER:
				
				//protection - set to default if not numeric
				if(is_string($value) && is_numeric($value) == false){
					
					if(empty($value))
						$value = 0;
					else
						$value = UniteFunctionsUC::getVal($param, "default_value");
					
				}
										
			break;
		}
		
		return($value);
	}
	
	/**
	 * get meta key value from objects
	 */
	private function getMetaValue($dataItem, $metaKey){

		switch($this->itemsType){
			case self::SOURCE_MENU:
			case self::SOURCE_POSTS:
		
				$postID = UniteFunctionsUC::getVal($dataItem, "id");
				
				$value = UniteFunctionsWPUC::getPostCustomField($postID, $metaKey);
			break;
			case self::SOURCE_TERMS:
				
				$termID = UniteFunctionsUC::getVal($dataItem, "term_id");
				
				if(empty($termID))
					return("");
				
				$arrFields = UniteFunctionsWPUC::getTermCustomFields($termID);
				
				$value = UniteFunctionsUC::getVal($arrFields, $metaKey);
								
			break;
			case self::SOURCE_USERS:
				
				$userID = UniteFunctionsUC::getVal($dataItem, "id");
				
				$arrMeta = UniteFunctionsWPUC::getUserMeta($userID, array($metaKey));
				
				$value = UniteFunctionsUC::getVal($arrMeta, $metaKey);
				
			break;
			default:
				
				UniteFunctionsUC::throwError("getMetaValue error - wrong source: ".$this->itemsType);
			break;
		}
		
		
		return($value);
	}
	
	/**
	 * get user avatar image
	 */
	private function getUserAvatarImage($dataItem, $defaultValue){
		
		if($this->itemsType != self::SOURCE_USERS)
			return($defaultValue);
		
		$userID = UniteFunctionsUC::getVal($dataItem, "id");
		
		if(empty($userID))
			return($defaultValue);
			
		$arrImage = UniteFunctionsWPUC::getUserAvatarData($userID);
		
		$urlAvatar = UniteFunctionsUC::getVal($arrImage, "avatar_url");
		
		if(empty($urlAvatar))
			return($defaultValue);
			
		return($urlAvatar);
		
	}
	
	/**
	 * get number of posts of some user
	 */
	private function getUserNumPosts($dataItem, $defaultValue){
		
		if($this->itemsType != self::SOURCE_USERS)
			return($defaultValue);
		
		$userID = UniteFunctionsUC::getVal($dataItem, "id");
		
		if(empty($userID))
			return($defaultValue);
		
		$numPosts = count_user_posts($userID);
			
		return($numPosts);
	}
	
	
	/**
	 * get field data from data item
	 */
	private function getFieldValue($item, $paramName, $source, $dataItem, $param){
		
		//set as default value
				
		$defaultValue = UniteFunctionsUC::getVal($param, "default_value");
		
		$item[$paramName] = $defaultValue;
		
		
		if($source == "default")
			return($item);
			
		//some protections
			
		if(empty($dataItem))
			return($item);
		
		
		if(!is_array($dataItem))
			return($item);
					
		$isProcessReturn = false;
			
		//process static value
		
		switch($source){
			case "static_value":
				$staticValueKey = $this->nameParam."_field_value_{$paramName}";
							
				$value = UniteFunctionsUC::getVal($this->arrValues, $staticValueKey);
							
				$isProcessReturn = true;
			break;
			case "meta_field":
				
				$metaField = $this->nameParam."_field_meta_{$paramName}";
				
				$metaKey = UniteFunctionsUC::getVal($this->arrValues, $metaField);
				
				$value = $defaultValue;
				
				if(!empty($metaKey))
					$value = $this->getMetaValue($dataItem, $metaKey);
				
				$isProcessReturn = true;
				
			break;
			case "user_avatar_image":
				
				$value = $this->getUserAvatarImage($dataItem, $defaultValue);
				
				$isProcessReturn = true;
			break;
			case "user_num_posts":
				
				$value = $this->getUserNumPosts($dataItem, $defaultValue);
				
				$isProcessReturn = true;
			break;
		}
		
		
		
		//return the static value or meta field
		
		if($isProcessReturn == true){
			
			$value = $this->modifyParamValue($value, $param);
			
			$item[$paramName] = $value;
			
			//modify the image size
			
			$type = UniteFunctionsUC::getVal($param, "type");
			
			if($type == UniteCreatorDialogParam::PARAM_IMAGE && !empty($this->itemsImageSize)){
				$param["add_image_sizes"] = true;
				$param["value_size"] = $this->itemsImageSize;
				
			}
			
			
			$item = $this->objProcessor->getProcessedParamData($item, $value, $param, UniteCreatorParamsProcessorWork::PROCESS_TYPE_OUTPUT);
			
			return($item);
		}
		
		
		//get the source name for field 
		if($source == "field")
			$source = UniteFunctionsUC::getVal($this->arrValues, $this->nameParam."_field_name_".$paramName);

			
		//post values source
		
		foreach($dataItem as $name => $value){
			
			//if equal - just copy the data
			
			if($name === $source){
				
				$value = $this->modifyParamValue($value, $param);
				
				$item[$paramName] = $value;
				
				
				$item = $this->objProcessor->getProcessedParamData($item, $value, $param, UniteCreatorParamsProcessorWork::PROCESS_TYPE_OUTPUT);
				
				continue;
			}
						
			//get children fields values
			
			if(strpos($name, $source."_") === 0){
				
				$suffix = substr($name, strlen($source));
				
				$item[$paramName.$suffix] = $value;				
			}
				
		}
		
		
		
		return($item);
	}
	
	private function _______GET_ITEMS________(){}
	
	
	/**
	 * get multisource items
	 */
	private function getItems($itemsSource, $arrData){
		
		if(empty($arrData))
			return(array());
					
		// get fields from settings
		
		$arrFields = $this->getFields();
		
		if(empty($arrFields)){
			
			UniteFunctionsUC::throwError("multisource getItems error: $itemsSource fields not found");
		}
		
		//get items params 
		
		$arrItemParams = $this->addon->getParamsItems();
		$arrItemParams = UniteFunctionsUC::arrayToAssoc($arrItemParams,"name");
		
		$arrItems = array();
			
		foreach($arrData as $index => $dataItem){
			
			$item = array();
			
			//get the fields values from data item
			
			$arrUsedParams = array();
			
			if($itemsSource != self::SOURCE_DEMO){
			
				foreach($arrFields as $fieldKey => $source){
					
					$paramName = str_replace($this->nameParam."_field_source_", "", $fieldKey);
					
					$param = UniteFunctionsUC::getVal($arrItemParams, $paramName);
					
					$item = $this->getFieldValue($item, $paramName, $source, $dataItem, $param);
					
					$arrUsedParams[$paramName] = true;
					
				}
			}
			
			//add other default fields
			
			foreach($arrItemParams as $itemParam){
				
				$paramName = UniteFunctionsUC::getVal($itemParam, "name");
				
				if(isset($arrUsedParams[$paramName]))
					continue;
				
				$value = UniteFunctionsUC::getVal($itemParam, "default_value");
				
				$item[$paramName] = $value;
				
				$item = $this->objProcessor->getProcessedParamData($item, $value, $itemParam, UniteCreatorParamsProcessorWork::PROCESS_TYPE_OUTPUT);
			}
			
			//modify demo fields
			
			if($itemsSource == self::SOURCE_DEMO){
				
				$title = UniteFunctionsUC::getVal($dataItem, "title");
				
				$item["title"] = $title;
			}
			
			//add extra fields
			
			$item["item_source"] = $itemsSource;
			
			$elementorID = UniteFunctionsUC::getRandomString(5);
			$item["item_repeater_class"] = "elementor-repeater-item-".$elementorID;
		    
			
			$arrItems[] = array("item" => $item);
			
		}
		
		
		return($arrItems);
			
	}
	
	/**
	 * get demo data for editor
	 */
	private function getDemoDataForEditor(){
		
		$arrDemo = array();
		
		$arrDemo[] = array("title"=>"Demo Item 1",
							"link"=> "Demo Link 1",
							"number"=> 10
		);
		
		$arrDemo[] = array("title"=>"Demo Item 2",
							"link"=> "Demo Link 2",
							"number"=> 20
		);
		
		$arrDemo[] = array("title"=>"Demo Item 3",
							"link"=> "Demo Link 3",
							"number"=> 30
		);
		
		
		return($arrDemo);
	}
	
	
	/**
	 * get multisource data
	 */
	public function getMultisourceSettingsData($value, $name, $processType, $param, $data){
		
    	$this->isInsideEditor = HelperUC::isElementorEditMode();
		
		$itemsSource = UniteFunctionsUC::getVal($value, $name."_source");
		
		
		//set the inputs
		
		$this->arrValues = $value;
		$this->name = $name;
		$this->nameParam = $name."_".$itemsSource;
		$this->param = $param;
		$this->processType = $processType;
		$this->inputData = $data;
		$this->itemsType = $itemsSource;
		
		
		//get image size
		$this->itemsImageSize = $this->objProcessor->getProcessedItemsData_getImageSize($processType);
		
		//debug
		
		$isShowInputData = UniteFunctionsUC::getVal($this->arrValues, $this->name."_show_input_data"); 
		$isShowInputData = UniteFunctionsUC::strToBool($isShowInputData);
		
		$this->showDebugData = $isShowInputData;
		
		$isShowMeta =  UniteFunctionsUC::getVal($this->arrValues, $this->name."_show_metafields"); 
		$isShowMeta = UniteFunctionsUC::strToBool($isShowMeta);
		
		$this->showDebugMeta = $isShowMeta;

		if($itemsSource == "items"){
			
			$data[$name] = "uc_items";
			
			if($this->showDebugData == true)
				self::$showItemsDebug = true;
			
			return($data);
		}
		
		
		$this->checkDebugBeforeData($itemsSource);
		
		$arrData = $this->getData($itemsSource);
		
		$this->showDebug($itemsSource, $arrData);
		
		if(empty($arrData) && $this->isInsideEditor == true){
			$arrData = $this->getDemoDataForEditor();
			
			$itemsSource = self::SOURCE_DEMO;
		
			$this->showDebug($itemsSource, $arrData);
			
		}
		
		$response = $this->getItems($itemsSource, $arrData);
		
		
		$data[$name] = $response;
				
		return($data);
	}
	
	/**
	 * show items debug from the output if needed
	 */
	public static function checkShowItemsDebug($arrItemData){
		
		if(self::$showItemsDebug == false)
			return(false);
			
		self::$showItemsDebug = false;
		
		$arrOutput = array();
		
		if(empty($arrItemData)){
			dmp("no items data found");
			return(false);
		}
		
		foreach($arrItemData as $item){
			
			if(count($item) == 1 && isset($item["item"]))
				$arrOutput[] = $item["item"];
		}

		dmp("Getting data from the settings items repeater");
		
		dmp($arrOutput);
		
	}
	
	
}
