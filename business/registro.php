<?php
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

$Registro = new Registro($Application->getDBConnector());
$Registro->useView(true);
$rows = $Registro->getAll(Registro::DATA_ARRIVO." desc, ".Corrieri::CORRIERE);
include(VIEWS_PATH.basename(__FILE__));
