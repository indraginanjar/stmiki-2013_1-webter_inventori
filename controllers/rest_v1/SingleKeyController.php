<?php
require_once dirname(__FILE__) . '/../../inc/IController.php';
require_once dirname(__FILE__) . '/../../inc/Controller.php';
require_once dirname(__FILE__) . '/../../inc/PageParam.php';
require_once dirname(__FILE__) . '/../../models/SingleKeyModel.php';
require_once dirname(__FILE__) . '/../../Config.php';

class SingleKeyController extends Controller implements IController {

	protected $_Config;
	protected $_PageUrl;
	protected $_DbConnection;
	protected $_Model;
	protected $_PageName;
	protected $_Uri;

	function __construct($pageName, $model, $controllerActionIndex){
		parent::__construct($controllerActionIndex);
		$this->_Config = new Config();
		$this->_PageName = $pageName;
		global $BaseUrl;
		$this->_PageUrl = $BaseUrl . 'index.php/Rest/' . $this->_PageName;
		$this->_Uri = 'http://' . $_SERVER['SERVER_NAME'] . $this->_PageUrl . '/';
		$this->_Model = $model;
		header('Content-type: application/json; charset=utf-8');
		//header('Content-type: text/html; charset=utf-8');
	}

	function ActionSingleKey(){
		$this->ActionIndex();
	}

	function HandleGet(){
		$IdActionIndex = $this->GetActionToExecuteIndex();
		$Id = $this->_Param->GetAction($IdActionIndex);
		$Action = array();
		if($Id == NULL){
			$this->WriteJsonSelectAll();
		}
		else {
			$this->WriteJsonSelectItem($Id, $this->GetUpdateFieldsClue($Id));
		}
	}

	function WriteJsonSelectItem($id, array $updateParams = NULL){
		$Statement = $this->_Model->SelectByKey($id);
		$Actions = array(
				(object) array(
						'name' => 'delete'
						, 'href' => $this->_Uri . $id
						, 'method' => 'DELETE'
						)
				);

		$UpdateClue = array(
				'name' => 'update'
				, 'href' => $this->_Uri
				, 'method' => 'POST'
				);

		if($updateParams != NULL){
			$Actions[] = (object) array_merge($UpdateClue, $updateParams);

		}

		$Response = array(
				'class' => array('item')
				, 'properties' => NULL
				, 'links' => array(
						(object) array(
								'rel' => array('self')
								, 'href' => $this->_Uri . $id
								)
						, (object) array(
								'rel' => array('up')
								, 'href' => $this->_Uri
								)
						)
				, 'actions' => $Actions
				);
		if($Row = $Statement->fetch(PDO::FETCH_NUM)){
			$Properties = array();
			for($I = 0; $I < $Statement->columnCount(); $I++){
				$Column = $Statement->getColumnMeta($I);
				$Properties = array_merge($Properties, array(
						$Column['name'] => $Row[$I]
							)
						);
			}
			$Response['properties'] = (object) $Properties;
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
									, 'href' => $this->_Uri . $id
									)
							)
					);
		}
		exit(json_encode($Response));
	}

	function WriteJsonSelectAll(array $updateParams = NULL){
		$CreateClue = array(
				'name' => 'create'
				, 'href' => $this->_Uri
				, 'method' => 'POST'
				);
		$CreateClue = array_merge($CreateClue, $this->GetUpdateFieldsClue(NULL));

		$Statement = $this->_Model->SelectAll();
		$Response = array(
				'class' => array('collection')
				, 'entities' => array()
				, 'links' => array(
						(object) array(
								'rel' => array('self')
								, 'href' => $this->_Uri
								)
						)
				, 'actions' => array((object) $CreateClue)
				);

		$UpdateClueBase = array(
				'name' => 'update'
				, 'href' => $this->_Uri
				, 'method' => 'POST'
				);


		foreach($Statement as $Row) {
			$UpdateClue = array_merge($UpdateClueBase, $this->GetUpdateFieldsClue($Row[0]));
			$Entity = array(
					'properties' => null
					, 'links' => array(
							'rel' => array('self')
							, 'href' => $this->_Uri . $Row[0]
							)
					, 'actions' => array(
							(object) array(
									'name' => 'delete'
									, 'method' => array('DELETE')
									, 'href' => $this->_Uri . $Row[0]
									)
							, (object) $UpdateClue
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
		exit(json_encode($Response));
	}

	function HandleDelete(){
		$IdActionIndex = $this->GetActionToExecuteIndex();
		$Id = $this->_Param->GetAction($IdActionIndex);
		if($Id == NULL){
			header('HTTP/1.1 400 Bad Request');
			$Response = array(
					'class' => array('error')
					, 'properties' => (object) array(
							'status' => 'failed'
							, 'message' => 'Missing Required Parameters'
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
		$Statement = $this->_Model->DeleteByKey($Id);
		if(!$Statement){
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
									, 'href' => $this->_Uri . $Id
									)
							)
					);
			exit(json_encode($Response));
		}
		header('HTTP/1.1 204 No Content');
		exit();
	}

	function GetPageUrl() {
		return $this->_PageUrl;
	}


	function GetModel(){
		return $this->_Model;
	}

	function GetParam() {
		return $this->_Param;
	}

	function GetUri(){
		return $this->_Uri;
	}

}
?>
