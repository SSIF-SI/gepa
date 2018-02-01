<?php 
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

$corrieriObj = new Corrieri($Application->getDBConnector());
$corrieri = Utils::getListfromField($corrieriObj->getAll(Corrieri::CORRIERE), Corrieri::CORRIERE, Corrieri::ID_CORRIERE);

$listOfPersone = Personale::getInstance()->getPersonale();

include(VIEWS_PATH.basename(__FILE__));
?>
