<?php

class Corrieri extends Crud {

	const ID_CORRIERE = "idCorriere";

	const CORRIERE = "corriere";

	protected $TABLE = "corrieri";
	
	public function __construct($connInstance) {
		parent::__construct ( $connInstance );
		$this->useView(false);
	}
}

?>
