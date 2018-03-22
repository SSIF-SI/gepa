<?php
require_once ("config.php");

if(isset($_GET[ActionManager::ACTION_LABEL])){
	$Application->manageAction($_GET[ActionManager::ACTION_LABEL]);
}

include(TEMPLATES_PATH."onepage.php");
?>