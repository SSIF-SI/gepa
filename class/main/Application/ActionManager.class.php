<?php 
class ActionManager {
	private $_dbConnector;
	
	const ACTION_LABEL = "action";
	
	public function __construct($dbConnector){
		$this->_dbConnector = $dbConnector;
	}
	
	public function save(){
		if(!Utils::checkAjax())
			die(ACCESS_DENIED);
		
		$ARP = new AjaxResultParser();
		$eh = new ErrorHandler(false);
		
		$dataArrivo = date("Y-m-d H:i:s");
		
		$registro = new Registro($this->_dbConnector);
		
		foreach($_POST[Registro::CODICE_ESTERNO] as $idDestinatario => $list){
			$this->_dbConnector->begin();
			foreach ($list as $idRow=>$codice){
				$registroRow = $registro->getStub();
				$registroRow[Registro::DATA_ARRIVO] = $dataArrivo;
				$registroRow[Registro::CODICE_ESTERNO] = $codice;
				$registroRow[Registro::ID_CORRIERE] = $_POST[Corrieri::CORRIERE][$idDestinatario][$idRow];
				$registroRow[Registro::DESTINATARIO] = $idDestinatario;
				$registroRow[Registro::PRIVATO] = $_POST[Registro::PRIVATO][$idDestinatario][$idRow];
				
				$result = $registro->save($registroRow);
				if($result->getErrors()){
					$this->_dbConnector->rollback();
					$eh->setErrors("Impossibile creare la riga di registro:".json_encode($registroRow));
					break 2;
				}
			}
			$nominativo = Personale::getInstance()->getNominativo($idDestinatario);
			$nPacchi = count($list);
			$vowel = $nPacchi == 1 ? "o" : "i";
			$sent = PHPMailer::sendMail(MAIL_FROM, "", "[TEST]", "$nominativo hai {$nPacchi} pacch{$vowel} da ritirare in magazzino");
			if($sent) 
				$this->_dbConnector->commit();
			else {
				$eh->setErrors("Impossibile inviare la mail a ".$nominativo);
				break;
			}
		}
		$ARP->encode($eh->getErrors(true));
	}
	
	public function getUser(){
		$numBadge = $_POST[Personale::NUM_BADGE];
		$list = Personale::getInstance()->getPersone();
		$persona = Utils::filterList($list, Personale::NUM_BADGE, $numBadge);
		if(is_array($persona)) $persona = reset($persona);
		$ARP = new AjaxResultParser();
		$ARP->encode($persona);
	}
}
?>