<?php 
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

$corrieriObj = new Corrieri($Application->getDBConnector());
$corrieri = Utils::getListfromField($corrieriObj->getAll(Corrieri::CORRIERE), Corrieri::CORRIERE, Corrieri::ID_CORRIERE);

$listOfPersone = Personale::getInstance()->getPersone();
foreach ($listOfPersone as $k=>$item){
	if(is_null($item[Personale::NUM_BADGE]))
		unset($listOfPersone[$k]);
} 

include(VIEWS_PATH.basename(__FILE__));
?>
