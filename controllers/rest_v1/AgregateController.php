<?php
require_once dirname(__FILE__) . '/SingleKeyController.php';

class AgregateController extends SingleKeyController {

	private $_OtherModels;

	function __construct($pageName, $model, array $otherModels, $controllerActionIndex){
		parent::__construct($pageName, $model, $controllerActionIndex);
		$this->_OtherModels = $otherModels;
	}
/*
	function HandleGet(){

		header('Content-type: application/json; charset=utf-8');
		$IdActionIndex = $this->GetActionToExecuteIndex();
		$Id = $this->_Param->GetAction($IdActionIndex);
		if($Id == NULL){
			$Statement = $this->_Model->SelectAll();
			$Action = array('actions' => (object) array(
							'name' => array('create')
							, 'href' => $this->_Uri
							, 'method' => 'POST'
							)
					);
		}
		else {
			$IsSearching = (strcasecmp($Id, 'search') == 0);
			if($IsSearching){
				$SearchQuery = PageParam::GetValue('q', 'GET');
				$Statement = $this->_Model->SelectFilteredByKey($SearchQuery);
			}
			else {
				$IsAskingItem = (strcasecmp($this->_Param->GetAction($IdActionIndex + 1), 'item') == 0);
				if($IsAskingItem){
					$Statement = $this->_Model->SelectViewByKey($Id);
				}
				else {
					$Statement = $this->_Model->SelectByKey($Id);
					$Action = array('actions' => (object) array(
									'name' => array('delete')
									, 'href' => $this->_Uri . $Id
									, 'method' => 'DELETE'
									)
							);
				}
			}
		}
		if($Statement) {
			$Response = array(
					'entities' => array()
					, 'links' => array(
							(object) array(
									'rel' => array('self')
									, 'href' => $this->_Uri . $Id
									)
							)
					, 'actions' => array(
							(object) array(
									'rel' => array('delete')
									, 'href' => $this->_Uri . $Id
									, 'method' => 'DELETE'
									)
							)
					);
			foreach($Statement as $Row) {
				$Entity = array(
						'properties' => null
						, 'links' => array(
								'rel' => array('self')
								, 'href' => $this->_Uri . $Row[0]
								)
						, 'actions' => array(
								'rel' => array('delete')
								, 'method' => array('DELETE')
								, 'href' => $this->_Uri . $Row[0]
								)
						);
				$Properties = array();
				for($I = 0; $I < $Statement->columnCount(); $I++){
					$Column = $Statement->getColumnMeta($I);
					$Properties = array_merge($Properties, array(
							$Column['name'] => $Row[$I]
								)
							);
				}
				$Entity['properties'] = (object) $Properties;
				$Response['entities'][] = (object) $Entity;
			}
			$Response['actions'] = $Action;
			exit(json_encode($Response));
		}
		else {
			header('HTTP/1.1 404 Not Found');
			$Response = array(
					'class' => array('error')
					, 'properties' => (object) array(
							'status' => 'error'
							, 'message' => 'Specified Record Are Not found'
							)
					, 'links' => array(
								(object) array(
									'rel' => 'self'
									, 'href' => $this->_Uri
									)
							)
					);
			exit(json_encode($Response));
		}
	}
*/

	function GetOtherModels(){
		return $this->_OtherModels;
	}

	function GetOtherModelsSelectAllStatement(){
		$Statements = array();
		foreach($this->_OtherModels as $Key => $Value) {
			$Statements = array_merge($Statements, array( ucfirst($Key) . 'Statement' => $Value->SelectAll()));
		}
		return $Statements;
	}
}?>
