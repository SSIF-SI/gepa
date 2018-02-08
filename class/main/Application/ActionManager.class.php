<?php 
class ActionManager {
	private $_dbConnector;
	private $_ARP;
	private $_eh;
		
	const ACTION_LABEL = "action";
	
	public function __construct($dbConnector){
		$this->_dbConnector = $dbConnector;
		$this->_ARP = new AjaxResultParser();
		$this->_eh = new ErrorHandler(false);
	}
	
	public function save(){
		if(!Utils::checkAjax())
			die(ACCESS_DENIED);
		
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
					$this->_eh->setErrors("Impossibile creare la riga di registro:".json_encode($registroRow));
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
				$this->_eh->setErrors("Impossibile inviare la mail a ".$nominativo);
				break;
			}
		}
		$this->_ARP->encode($this->_eh->getErrors(true));
	}
	
	public function getUser(){
		$numBadge = $_POST[Personale::NUM_BADGE];
		$list = Personale::getInstance()->getPersone();
		$persona = Utils::filterList($list, Personale::NUM_BADGE, $numBadge);
		if(is_array($persona)) $persona = reset($persona);
		$this->_ARP = new AjaxResultParser();
		$this->_ARP->encode($persona);
	}
	
	function dispatch(){
		
		$ids = $_POST['ids'];
		$ricevente = $_POST['ricevente'];
		$registro = new Registro($this->_dbConnector);
		$nominativo = Personale::getInstance()->getNominativo($ricevente);

		$registro->updatePack($ids, $ricevente);
		$errors = $this->_dbConnector->getLastError();
		if($errors){
			$this->_eh->setErrors("Impossibile salvare i dati: ".$errors);
		} else {

			$nPacchi = count($ids);
			$vowel = $nPacchi == 1 ? "o" : "hi";
			$sent = PHPMailer::sendMail(MAIL_FROM, "", "[TEST]", "$nominativo hai ritirato {$nPacchi} pacc{$vowel} dal magazzino.");
			if(!$sent){
				$this->_eh->setErrors("Impossibile inviare alcune mail di notifica");
			}
			$listOfPack = $registro->getBy(Registro::ID_PACCO, $ids);
			$listOfPack = Utils::groupListBy($listOfPack, Registro::DESTINATARIO);
			foreach($listOfPack as $idPersona=>$list){
				if($idPersona == $ricevente) continue;
				$nPacchi = count($list);
				$vowel = $nPacchi == 1 ? "o" : "hi";
				$vowelD = $nPacchi == 1 ? "o" : "i";
				$sent = PHPMailer::sendMail(MAIL_FROM, "", "[TEST]", "$nominativo ha ritirato {$nPacchi} pacc{$vowel} destinat{$vowelD} a te dal magazzino.");
				if(!$sent){
					$this->_eh->setErrors("Impossibile inviare alcune mail di notifica");
				}
			}
		}
		
		$this->_ARP->encode($this->_eh->getErrors(true));

	}
	
	function deleteCorriere(){
		$Corrieri = new Corrieri($this->_dbConnector);
		$this->_eh = $Corrieri->delete(array(Corrieri::ID_CORRIERE => $_POST[Corrieri::ID_CORRIERE]));
		$this->_ARP->encode($this->_eh->getErrors(true));
	}
	
	function editCorriere(){
		$Corrieri = new Corrieri($this->_dbConnector);
		
		if(count($_POST)){
			$corriere = Utils::stubFill($Corrieri->getStub(), $_POST);
			$this->_eh = $Corrieri->save($corriere);
			$this->_ARP->encode($this->_eh->getErrors(true));
			return;
		}
		
		$corriere = isset($_GET[Corrieri::ID_CORRIERE]) ? $Corrieri->get(array(Corrieri::ID_CORRIERE => $_GET[Corrieri::ID_CORRIERE])) : $Corrieri->getStub();
		include(VIEWS_PATH."formCorriere.php");
		die();
	}
}
?>