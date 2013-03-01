<?php

class Application_Model_DbTable_InscriptionsIndividuelles extends Projet_Db_Table {
	const NAME = 'INSCRIPTIONS_INDIVIDUELLES';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
