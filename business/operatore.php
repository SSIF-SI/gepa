<?php 
$view = VIEWS_PATH.basename(__FILE__);
if(!Utils::checkAjax()){
	include(TEMPLATES_PATH."onepage.php");
} else{
	if(isset($_GET[ActionManager::ACTION_LABEL])){
		$Application->manageAction($_GET[ActionManager::ACTION_LABEL]);
		die();
	}
	include($view);
}
	
?>
