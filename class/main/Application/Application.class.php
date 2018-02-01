<?php

class Application {

	/*
	 * La classe principale di DIDO
	 *
	 * Dido gestisce i documenti utilizzando 3 sorgenti principali:
	 *
	 * - Repository FTP
	 * - Master Document Manager (Database)
	 * - Lista di XML descrittivi per ogni tipologia di documento (files)
	 *
	 * Dido Importa i documenti anche da sorgenti esterne (attualmente solo da
	 * GECO)
	 *
	 * L'accesso a Dido è riservato agli utenti ISTI con vari livelli di
	 * permessi.
	 *
	 */
	
	/*
	 * Connettore al DB, verrà utilizzato da svariate classi
	 */
	private $_dbConnector;

	/*
	 * Sorgenti di dati FTP
	 */
	private $_FTPDataSource;

	/*
	 * Sorgente XML
	 */
	private $_XMLDataSource;

	/*
	 * Gestione dati dell'utente collegato
	 */
	private $_userManager;

	private $_ActionManager;
	
	public function __construct() {
		$this->_dbConnector = DBConnector::getInstance ();
		$this->_ActionManager = new ActionManager($this->_dbConnector);
	}

	public function getDBConnector(){
		return $this->_dbConnector;
	}
	
	public function manageAction($action){
		if(!method_exists($this->_ActionManager, $action))
			return new ErrorHandler("Azione non prevista");
	
		return $this->_ActionManager->$action();
	}
}
?>