<?php
require_once("../config.php");
if(!Utils::checkAjax())
	Common::redirect();

$Registro = new Registro($Application->getDBConnector());
$Registro->useView(true);
$rows['all'] = $Registro->getGeneric(Registro::DESTINATARIO.", count(*) as tot", $Registro->getTableName(), Registro::PRIVATO." = 1 group by ".Registro::DESTINATARIO, "tot DESC");
$rows['week'] = $Registro->getGeneric(Registro::DESTINATARIO.", count(*) as tot", $Registro->getTableName(), Registro::PRIVATO." = 1 and ".Registro::DATA_ARRIVO."  > date_sub( now( ) , INTERVAL 1 WEEK )  group by ".Registro::DESTINATARIO, "tot DESC");
include(VIEWS_PATH.basename(__FILE__));
