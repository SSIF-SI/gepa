<?php 
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

$registro = new Registro($Application->getDBConnector());
$pacchiInUscita = $registro->getBy(Registro::RICEVENTE, null, Registro::DATA_ARRIVO.", ".Registro::ID_CORRIERE);
$pacchiInUscita = Utils::groupListBy($pacchiInUscita, Registro::DESTINATARIO);

$corrieriObj = new Corrieri($Application->getDBConnector());
$corrieri = Utils::getListfromField($corrieriObj->getAll(Corrieri::CORRIERE), Corrieri::CORRIERE, Corrieri::ID_CORRIERE);

$listOfPersone = Personale::getInstance()->getPersone();
foreach ($listOfPersone as $k=>$item){
	if(is_null($item[Personale::NUM_BADGE]))
		unset($listOfPersone[$k]);
}

include(VIEWS_PATH.basename(__FILE__));
?>
