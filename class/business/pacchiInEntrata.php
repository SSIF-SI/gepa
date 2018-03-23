<?php 
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

var_dump($Application);

$corrieriObj = new Corrieri($Application->getDBConnector());

include(VIEWS_PATH.basename(__FILE__));
?>
