<?php

class Application_Model_DbTable_InscriptionsTournois extends Projet_Db_Table {
	const NAME = 'INSCRIPTIONS_TOURNOIS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
