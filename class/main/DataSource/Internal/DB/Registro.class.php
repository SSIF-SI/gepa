<?php

class Registro extends Crud {

	const ID_PACCO = "idPacco";
	
	const DATA_ARRIVO = "dataArrivo";
	
	const CODICE_ESTERNO = "codiceEsterno";
	
	const ID_CORRIERE = Corrieri::ID_CORRIERE;
	
	const DESTINATARIO = "destinatario";
	
	const RICEVENTE = "ricevente";
	
	const DATA_CONSEGNA = "dataConsegna";
	
	const PRIVATO = "privato";
	
	protected $TABLE = "registro";
	
	protected $VIEW = "registro_view";

	public function __construct($connInstance) {
		parent::__construct ( $connInstance );
		$this->useView(false);
	}
}

?>
