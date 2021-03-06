<?php 
class ActionManager {
	private $_dbConnector;
	private $_ARP;
	private $_eh;
		
	const ACTION_LABEL = "action";
	
	private static $VALID_USERS = array(
		756, 	/* Ribolini */
		10265, 	/* Verri */
		10277, 	/* Lipari */
		10372,	/* Fantini */
		10506, 	/* Coco */
		10819, 	/* Lombardi */
		11027, 	/* Volpini */ 
		15012, 	/* Trentanni */
	    10226  /* Pavoni */
	);
	
	public function __construct($dbConnector){
		$this->_dbConnector = $dbConnector;
		$this->_ARP = new AjaxResultParser();
		$this->_eh = new ErrorHandler(false);
	}
	
	public function delete(){
		if(!Utils::checkAjax())
			die(ACCESS_DENIED);
		$registro = new Registro($this->_dbConnector);
		$ids = $_POST['ids'];
		$objects = $registro->getBy(Registro::ID_PACCO, $ids);
		
		$this->_dbConnector->begin();
		foreach($objects as $object){
			$eh = $registro->delete($object);
			if($eh->getErrors()){
				$this->_dbConnector->rollBack();
				$this->_ARP->encode($eh->getErrors(true));
				return;
			}
		}

		$this->_dbConnector->commit();
		$this->_ARP->encode($this->_eh->getErrors(true));
	}
	
	public function save(){
		if(!Utils::checkAjax())
			die(ACCESS_DENIED);
		
		$dataArrivo = date("Y-m-d H:i:s");
		
		$registro = new Registro($this->_dbConnector);
		
		foreach($_POST[Registro::CODICE] as $idDestinatario => $list){
			$this->_dbConnector->begin();
			$listToSignal = array();
			foreach ($list as $idRow=>$codice){
				$privato = $_POST[Registro::PRIVATO][$idDestinatario][$idRow];
				$registroRow = $registro->getStub();
				$registroRow[Registro::DATA_ARRIVO] = $dataArrivo;
				$registroRow[Registro::CODICE] = $codice;
				$registroRow[Registro::ID_CORRIERE] = $_POST[Corrieri::CORRIERE][$idDestinatario][$idRow];
				$registroRow[Registro::DESTINATARIO] = $idDestinatario;
				$registroRow[Registro::PRIVATO] = $privato;
				$registroRow[Registro::MEPA] = $_POST[Registro::MEPA][$idDestinatario][$idRow];
				
				$result = $registro->save($registroRow);
				if($result->getErrors()){
					$this->_dbConnector->rollback();
					$this->_eh->setErrors("Impossibile creare la riga di registro:".json_encode($registroRow));
					break 2;
				}
				if($privato) array_push($listToSignal, $codice);
			}
			$nominativo = Personale::getInstance()->getNominativo($idDestinatario);
			$to = Personale::getInstance()->getEmail($idDestinatario);
			if(!$to) $to = "";
			$nPacchi = count($listToSignal);
			
			if($nPacchi > 0){
				$vowel = $nPacchi == 1 ? "o" : "hi";
				$vowelD = $nPacchi == 1 ? "o" : "i";
				$sent = PHPMailer::sendMail(MAIL_FROM, $to, "Nuovi pacchi in magazzino", "$nominativo hai {$nPacchi} nuov{$vowelD} pacc{$vowel} da ritirare in magazzino.\nRicorda di portare con te il badge.\n\nPer informazioni numeri interni di riferimento: 3135/3140 ");
			} else {
				$sent = true;
			}
			
			if($sent) 
				$this->_dbConnector->commit();
			else {
				$this->_dbConnector->rollback();
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
		if(!Session::getInstance()->exists(AUTH_USER)){
			/* Controllo operatore */
			if(isset($persona[Personale::NUM_BADGE]) && !in_array($_POST[Personale::NUM_BADGE], self::$VALID_USERS)){
				$this->_ARP->encode(array("pruut" => true));
				return;		 
			}
		}
		$this->_ARP->encode($persona);
	}
	
	public function setUser(){
		$user = Personale::getInstance()->getEmail($_POST['operatore']);
		Session::getInstance()->set(AUTH_USER, $user);
		Session::getInstance()->set(AUTH_USER, $user);
		$this->_eh->setOtherData("user", Personale::getInstance()->getNominativo($_POST['operatore']));
		$this->_ARP->encode($this->_eh->getErrors(true));
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

			$to = Personale::getInstance()->getEmail($ricevente);
			$nPacchi = count($ids);
			$vowel = $nPacchi == 1 ? "o" : "hi";
			$sent = PHPMailer::sendMail(MAIL_FROM, $to, "Ritiro pacchi dal magazzino", "$nominativo hai ritirato {$nPacchi} pacc{$vowel} dal magazzino.");
			if(!$sent){
				$this->_eh->setErrors("Impossibile inviare alcune mail di notifica");
			}
			
			$listOfPack = $registro->getBy(Registro::ID_PACCO, $ids);
			$listOfPack = Utils::groupListBy($listOfPack, Registro::DESTINATARIO);
			
			foreach($listOfPack as $idPersona=>$list){
				$nPacchi = count($list);
				if($idPersona == $ricevente) continue;
				$to = Personale::getInstance()->getEmail($idPersona);
				if(!$to) $to = "";
				$nPacchi = count($list);
				$vowel = $nPacchi == 1 ? "o" : "hi";
				$vowelD = $nPacchi == 1 ? "o" : "i";
				$sent = PHPMailer::sendMail(MAIL_FROM, $to, "Ritiro pacchi dal magazzino", "$nominativo ha ritirato {$nPacchi} pacc{$vowel} destinat{$vowelD} a te dal magazzino.");
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
