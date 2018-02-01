<?php 
class ActionManager {
	private $_dbConnector;
	
	const ACTION_LABEL = "action";
	
	public function __construct($dbConnector){
		$this->_dbConnector = $dbConnector;
	}
}
?>