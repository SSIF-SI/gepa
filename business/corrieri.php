<?php
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

$Corrieri = new Corrieri($Application->getDBConnector());
$rows = $Corrieri->getAll(Corrieri::CORRIERE);
include(VIEWS_PATH.basename(__FILE__));
