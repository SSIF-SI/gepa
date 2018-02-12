<?php

class Registro extends Crud {

	const ID_PACCO = "idPacco";
	
	const DATA_ARRIVO = "dataArrivo";
	
	const CODICE = "codice";
	
	const ID_CORRIERE = Corrieri::ID_CORRIERE;
	
	const DESTINATARIO = "destinatario";
	
	const RICEVENTE = "ricevente";
	
	const DATA_CONSEGNA = "dataConsegna";
	
	const PRIVATO = "privato";
	
	const MEPA = "mepa";
	
	protected $TABLE = "registro";
	
	protected $VIEW = "registro_view";
	
	private $SQL_UPDATE_MULTIPLE_PACKS = "UPDATE %s SET %s = %d, %s = '%s' WHERE %s IN (%s)";
	
	public function __construct($connInstance) {
		parent::__construct ( $connInstance );
		$this->useView(false);
	}
	
	public function updatePack($ids, $ricevente){
		$dataConsegna = date("Y-m-d H:i:s");
		$sql = sprintf($this->SQL_UPDATE_MULTIPLE_PACKS, $this->TABLE, self::RICEVENTE, $ricevente, self::DATA_CONSEGNA, $dataConsegna, self::ID_PACCO, join(", ",$ids));
		$this->_connInstance->query($sql);
	}
}

?>
